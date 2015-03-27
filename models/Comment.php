<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Comment extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [
            'message' => 'Сообщение'
        ];
    }

    public function rules()
    {
        return [
            ['message', 'required'],
            ['message', 'trim'],
            ['message', 'string', 'max' => 255]
        ];
    }

    public function getNote()
    {
        return $this->hasOne(Note::className(), ['id' => 'note_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCommentClosures()
    {
        return $this->hasMany(CommentClosure::className(), ['parent_id' => 'id'])
            ->where(['depth' => 1]);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['id' => 'child_id'])
            ->via('commentClosures');
    }

    public static function findCommentsTree($noteId)
    {
        $commentsIdsWithoutParents = Yii::$app->db
            ->createCommand('SELECT DISTINCT parent_id FROM comment_closure WHERE parent_id NOT IN (SELECT DISTINCT child_id FROM comment_closure WHERE parent_id != child_id)')
            ->queryAll(\PDO::FETCH_COLUMN);

        $commentWithStmt = mb_substr(str_repeat(
            'comments.',
            Yii::$app->db
                ->createCommand('SELECT MAX(comment_closure.depth) FROM comment INNER JOIN comment_closure ON (comment.id = comment_closure.parent_id) WHERE comment.note_id = :noteId', ['noteId' => $noteId])
                ->queryOne(\PDO::FETCH_COLUMN) + 1
        ), 0, -1, 'UTF-8');

        $comments = \app\models\Comment::find()->with($commentWithStmt)
            ->where(['note_id' => $noteId])
            ->andWhere(['in', 'id', $commentsIdsWithoutParents])
            ->all();

        $sortedComments = [];
        foreach ($comments as $comment) {
            static::walkTree($comment, $sortedComments);
        }

        return $sortedComments;
    }

    private static function walkTree(Comment $commentNode, array &$sortedNodes, $depth = 0)
    {
        $sortedNodes[] = [
            'comment' => $commentNode,
            'depth' => $depth
        ];

        $depth++;

        foreach ($commentNode->comments as $chidComment) {
            static::walkTree($chidComment, $sortedNodes, $depth);
        }
    }
}

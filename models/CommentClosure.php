<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class CommentClosure extends ActiveRecord
{
    public static function tableName()
    {
        return 'comment_closure';
    }

    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['id' => 'parent_id']);
    }

    public static function insertComment($id, $parentId = null) {
        return Yii::$app->db
            ->createCommand(
                'INSERT INTO comment_closure (parent_id, child_id, depth) SELECT parent_id, :child_id, depth + 1 FROM comment_closure WHERE child_id = :parent_id UNION SELECT :child_id, :child_id, 0',
                [':parent_id' => $parentId, ':child_id' => $id]
            )
            ->execute();
    }

    public static function findChildrenIds($parentId)
    {
        return Yii::$app->db
            ->createCommand('SELECT child_id FROM comment_closure WHERE parent_id = :parent_id', [':parent_id' => $parentId])
            ->queryColumn();
    }
}

<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Note;

class NoteSearch extends Note
{
    public $username;

    public function rules()
    {
        return [
            [['id', 'name', 'description', 'username'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['username'] = 'Имя пользователя';

        return $labels;
    }

    public function scenarios()
    {
        return [
            'all' => ['name', 'description', 'username'],
            'own' => ['name', 'description']
        ];
    }

    public function search($params, $whereParams)
    {
        $query = Note::find()->where($whereParams);

        if ($this->load($params) && $this->validate()) {
            if ($this->username !== '' && $this->username !== null) {
                $query->innerJoin('user', 'note.user_id = user.id')
                    ->andWhere(['like', 'user.name', $this->username]);
            }

            $query->andFilterWhere(['like', 'note.name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description]);
        }

        $noteProvider = new ActiveDataProvider([
            'query' => Note::find(),
            'sort' => [
                'attributes' => [
                    'name' => [
                        'asc' => ['note.name' => SORT_ASC],
                        'desc' => ['note.name' => SORT_DESC],
                        'label' => $this->getAttributeLabel('name')
                    ],
                    'description' => [
                        'label' => $this->getAttributeLabel('description')
                    ],
                    'created_at' => [
                        'default' => SORT_DESC,
                        'label' => $this->getAttributeLabel('created_at')
                    ]
                ],
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 9,
                'defaultPageSize' => 9
            ]
        ]);

        return $noteProvider;
    }
}

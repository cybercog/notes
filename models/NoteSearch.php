<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Note;

class NoteSearch extends Note
{

    public function rules()
    {
        return [
            [['name', 'description'], 'safe'],
        ];
    }

    public function search($params, $whereParams)
    {
        $query = Note::find()->where($whereParams);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description]);
        }

        $noteProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['name', 'description', 'created_at'],
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 10,
                'defaultPageSize' => 10
            ]
        ]);

        return $noteProvider;
    }
}

<?php
namespace app\models;

use app\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'email', 'name', 'created_at', 'role.item_name'], 'safe']
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['role.item_name']);
    }

    public function search($params)
    {
        $query = User::find()->joinWith(['role' => function($query) { $query->from(['role' => 'auth_assignment']); }]);

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'created_at', $this->created_at])
                ->andFilterWhere(['like', 'role.item_name', $this['role.item_name']]);
        }

        $userProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id', 'email', 'name',
                    'created_at' => [
                        'asc' => ['user.created_at' => SORT_ASC],
                        'desc' => ['user.created_at' => SORT_DESC],
                        'default' => SORT_DESC
                    ],
                    'role.item_name'
                ],
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 10,
                'defaultPageSize' => 10
            ]
        ]);

        return $userProvider;
    }
}

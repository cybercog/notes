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
                ->andFilterWhere(['like', 'role.item_name', $this['role.item_name']]);
                if (preg_match('/[\d]{2}-[\d]{2}-[\d]{4}/', $this->created_at)) {
                    $query->andFilterWhere([
                        'AND',
                        ['>', 'user.created_at', \DateTime::createFromFormat('d-m-Y H:i:s', $this->created_at . ' 00:00:00')->getTimestamp()],
                        ['<', 'user.created_at', \DateTime::createFromFormat('d-m-Y H:i:s', $this->created_at . ' 23:59:59')->getTimestamp()]
                    ]);
                }
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

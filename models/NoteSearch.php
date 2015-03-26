<?php
namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Note;

class NoteSearch extends Note
{
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['user.name'] = 'Имя пользователя';

        return $labels;
    }

    public function rules()
    {
        return [];
    }

    public function scenarios()
    {
        return [
            'admin' => ['id', 'name', 'visibility', 'created_at', 'user.name'],
            'all' => ['name', 'description', 'user.name'],
            'own' => ['name', 'description']
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['user.name']);
    }

    public function search($params, $whereParams = null)
    {
        $query = Note::find()->joinWith(User::tableName());
        $isAdminPanel = $this->getScenario() === 'admin';

        if ($whereParams) {
            $query->where($whereParams);
        }

        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'note.name', $this->name])
                ->andFilterWhere(['like', 'user.name', $this['user.name']]);

            if ($isAdminPanel) {
                $query->andFilterWhere(['note.id' => $this->id])
                    ->andFilterWhere(['visibility' => $this->visibility]);

                if (preg_match('/[\d]{2}-[\d]{2}-[\d]{4}/', $this->created_at)) {
                    $query->andFilterWhere([
                        'AND',
                        ['>', 'note.created_at', \DateTime::createFromFormat('d-m-Y H:i:s', $this->created_at . ' 00:00:00')->getTimestamp()],
                        ['<', 'note.created_at', \DateTime::createFromFormat('d-m-Y H:i:s', $this->created_at . ' 23:59:59')->getTimestamp()]
                    ]);
                };
            } else {
                $query->andFilterWhere(['like', 'description', $this->description]);
            }
        }

        $noteSortAttributes = [
            'name' => [
                'asc' => ['note.name' => SORT_ASC],
                'desc' => ['note.name' => SORT_DESC],
                'label' => $this->getAttributeLabel('name')
            ],
            'created_at' => [
                'default' => SORT_DESC,
                'label' => $this->getAttributeLabel('created_at')
            ]
        ];
        if ($isAdminPanel) {
            array_push($noteSortAttributes, 'id', 'user.name', 'visibility');
        } else {
            $noteSortAttributes['description'] = [
                'label' => $this->getAttributeLabel('description')
            ];
        }

        $noteProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => $noteSortAttributes,
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => $isAdminPanel ? 10 : 9,
                'defaultPageSize' => $isAdminPanel ? 10 : 9
            ]
        ]);

        return $noteProvider;
    }
}

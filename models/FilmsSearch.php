<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Films;

/**
 * FilmsSearch - поиск фильмов. Формирует запрос для отображения списка
 * с учетом страниц и колличества фильмов на странице
 */
class FilmsSearch extends Films
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['subj', 'date', 'post'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Формирование запроса к БД
     * @param array $params
     * @param int $itemsInPage - количество новостей на странице
     * @return ActiveDataProvider
     */
    public function search($params, $itemsInPage)
    {
        $query = Films::find()->orderBy(['date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $itemsInPage,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'subj', $this->subj])
            ->andFilterWhere(['like', 'post', $this->post]);

        return $dataProvider;
    }
}

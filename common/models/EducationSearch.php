<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Education;

/**
 * EducationSearch represents the model behind the search form about `common\models\Education`.
 */
class EducationSearch extends Education
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'institution_type', 'graduated_status', 'created_by', 'updated_by'], 'integer'],
            [['institution_name', 'institution_location', 'from_date', 'to_date', 'description', 'created_at', 'updated_at'], 'safe'],
            [['gpa', 'gpa_max'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public static function searchByUser($id)
    {
        $query = Education::find();
		$query->where(['user_id'=>$id]);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        return $dataProvider;
    }
}

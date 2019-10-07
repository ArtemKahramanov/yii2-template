<?php

namespace frontend\modules\menu\controllers;

use app\controllers\AccessController;
use Yii;
use frontend\modules\menu\models\MenuSearch;
use frontend\modules\menu\models\Menu;
use yii\base\Controller;
use yii\web\NotFoundHttpException;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class DefaultController extends Controller
{

//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    // Перемещение пунктов типа Link
    private function changeItem($modelSort, $direction, $model)
    {
        $modelSort->sortDirection($direction);
        if ($modelSort->type == 'Dropmenu') {
            foreach (Menu::find()->where(['parent_id' => $modelSort->id])->all() as $item) {
                $item->sortDirection($direction);
                $item->save();
            }
        }
        $direction == 'up' ? $model->sort -= 1 : $model->sort += 1;
        $modelSort->save();
    }

    // Изменение сортировки у подпунктов
    private function changeItemChild($direction)
    {
        $modelItemSort = Menu::find()->where(['sort' => ($direction == 'up' ? $model->sort - 0.1 : $model->sort + 0.1)])->one();
        $modelItemSort->sortDirection($direction, 0.1);
        $direction == 'up' ? $model->sort -= 0.1 : $model->sort += 0.1;
        $modelItemSort->save();
    }

    // Перемещение пунктов с выпадающем списком
    private function changeDropmenuItem($direction, $model, $modelSort)
    {
        $direction == 'up' ? $model->sort -= 1 : $model->sort += 1;
        // Изменение сортировки у подпунктов
        foreach (Menu::find()->where(['parent_id' => $model->id])->all() as $item) {
            $direction == 'up' ? $item->sort -= 1 : $item->sort += 1;
            $item->save();
        }
        $modelSort->sortDirection($direction);
        // Поменять местами два пункта с выпадающем списком
        if ($modelSort->type == 'Dropmenu') {
            foreach (Menu::find()->where(['parent_id' => $modelSort->id])->all() as $item) {
                $item->sortDirection($direction);
                $item->save();
            }
        }
        $modelSort->save();
    }

    private function changeDirection($id, $direction)
    {
        $model = Menu::findOne($id);
        if ($model->sort > 0) {
            // Выбор пункта на единицу выше/ниже переданного
            $modelSort = Menu::find()->where(['sort' => ($direction == 'up' ? $model->sort - 1 : $model->sort + 1)])->one();
            if ($model->parent_id == 0 && $model->type !== 'Dropmenu') {
                $this->changeItem($modelSort, $direction, $model);
            } elseif ($model->parent_id > 0) {
                $this->changeItemChild($direction);
            } elseif ($model->type === 'Dropmenu') {
                $this->changeDropmenuItem($direction, $model, $modelSort);
            }
        } elseif ($model->sort == 0) {
            foreach (Menu::find()->all() as $sort) {
                $sort->sort = $sort->sort + 1;
                $sort->save();
            }
            $model->sort = 1;
        }
        $model->save();
    }

    public function actionChangeOrder($id, $direction)
    {
        $model = Menu::findOne($id);
        $this->changeDirection($model->id, $direction);
        return $this->redirect('index');
    }


    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

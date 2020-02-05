<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\db\Query;
//use yii\web\Controller;
use frontend\controllers\AppController;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;

//Профиль
use frontend\models\ProfilePage; 
use frontend\models\ProfileEdit; 

//Профессиии
use frontend\models\Prof;
use frontend\models\Viewprof; 

//Где работать
use frontend\models\Job; 
use frontend\models\Jobview;

//Где учиться
use frontend\models\Vyz; 
use frontend\models\Sinceview;

//Карта
use frontend\models\Map; 

//Соыбтия
use frontend\models\Event;
use frontend\models\Eventview;


//Моя организация
use frontend\models\Mycompany;
use frontend\models\Editmyevent;

//Тесты
use frontend\models\Tests;
use frontend\models\Testview;
use frontend\models\Testedit;


//Блоги
use frontend\models\Blog;
use frontend\models\Blogview;
use frontend\models\Editmyblog;

// Добавление сертификата билета  в будующие портфолио
use frontend\models\SertificatForBilet;

//Ученики список - организация
use frontend\models\Liststudents;


//регистрация учителей 
use frontend\models\TeachersigForm;
/**
 * Site controller
 */
class SiteController extends AppController
{
    public function beforeAction($action)
    {
        //если куки удавлетворяют условию 
        if ($_COOKIE['gameCookie'] == 'KRxVuPXq5j38ZU') {
        	
        	if (!Yii::$app->user->isGuest) {
        		//если пользователь не гость
        		if (in_array($action->id, ['signup']) || in_array($action->id, ['login'])) {
	                return \Yii::$app->getResponse()->redirect('/profile')->send();
            	}
                if (!empty(Yii::$app->user->identity->first_name) && !empty(Yii::$app->user->identity->last_name)){
                    $sertmodel = new SertificatForBilet;
                    $sertmodel->createDompdf();
                    unset($sertmodel);
                }
        	}
        } 
        //выполняй действие
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return \Yii::$app->getResponse()->redirect('/profile')->send();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionShools()
    {
        return $this->render('shools');
    }
    public function actionStudents()
    {
        return $this->render('students');
    }
    public function actionJobandorg()
    {
        return $this->render('jobandorg');
    }
    public function actionObrorg()
    {
        return $this->render('obrorg');
    }
    public function actionOurproject()
    {
        return $this->render('ourproject');
    }
    public function actionInno()
    {
        return $this->render('inno');
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */

    //Собйтия
    public function actionEvent()
    {

        $array = Event::getEvent(); //События массив
        $sliderTop = Event::getSlider(); //Слайдер событий 

        return $this->render('event',[
        	'varInView' => $array,
        	'varTopSlider' => $sliderTop
        ]);
    }

    public function actionEventview() {

    	$arrayFullEvent = Eventview::getFullEvent(); //Массив с таблицы организации
    	$arrayOrg = Eventview::getOrg(); //Массив с таблицы направления
    	$arrayViewAddress = Eventview::getAdres(); // Массив с адресами организаций
    	$arrayViewFavoriteUserEvent = Eventview::getFavoriteUser(); //Добавлена ли организация в избранные
    	$getSlider = Eventview::getSlider();
    	$getNoti = Eventview::getNoti();

    	return $this->render('eventview', [
    		'getNoti' => $getNoti, // увидомление
    		'arrayFullEvent' => $arrayFullEvent,  //Массив с таблицы Event
    		'arrayOrg' => $arrayOrg, //Массив с таблицы Организации
    		'arrayViewAddress' => $arrayViewAddress, // Массив с адресами события
    		'arrayViewFavoriteUserEvent' => $arrayViewFavoriteUserEvent,  //Добавлена ли организация в избранные
    		'getSlider' => $getSlider,
    	]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    //return $this->goHome();
                    return \Yii::$app->getResponse()->redirect('/profile')->send();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionTeachersig()
    {
        $model = new TeachersigForm();
        $getSchool = TeachersigForm::getSchoolOrganisation();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    //return $this->goHome();
                    return \Yii::$app->getResponse()->redirect('/profile')->send();
                }
            }
        }
        return $this->render('teachersig', [
            'model' => $model,
            'getSchool' => $getSchool,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
   /** public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordReset', [
            'model' => $model,
        ]);
    }*/

    public function actionResetpassword() {
        return $this->render('resetpassword');
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
  /**  public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    } */


    //Профиль

    public function actionProfile()
    {

        $array = ProfilePage::getAll(); // Данные пользователя  
        $arrayTableProfile = ProfilePage::getProfileInfo(); // Дополнительные данные пользователя
        $arrayOrgUser = ProfilePage::getOrgUser(); // Организации пользователя
        $arrayProfessionUser = ProfilePage::getProfessionUser(); // Профессии пользователя
        $arrayAchiv = ProfilePage::getAchiv(); // Последнее достижение
        $getAllAchivUser = ProfilePage::getAllAchivUser(); // Все достижения 
        $getCompetenct = ProfilePage::getCompetenc(); // Компетенции
        $arrayEventUser = ProfilePage::getEventUser(); // События пользователя
        $arrayUserCompany = ProfilePage::getUserCompany(); // список компаний юузера
        $getNoti = ProfilePage::getNoti(); // увидомления
        $getSert = ProfilePage::getSert();
        $getUserSertCustom = ProfilePage::getUserSertCustom();
        $getSchoolUserMainPage = ProfilePage::getSchoolUserMainPage();
        $getStudentsInProfile = Liststudents::getStudentsInProfile();

        return $this->render('profile',[
        	'varInView' => $array,// Данные пользователя  
        	'varInViewProfileTable' => $arrayTableProfile, // Дополнительные данные пользователя
        	'varInViewOrgUser' => $arrayOrgUser, // Организации пользователя
        	'varInViewProfessionUser' => $arrayProfessionUser, // Профессии пользователя
        	'getAchiv' => $arrayAchiv,  // Последнее достижение
        	'getAllAchivUser' => $getAllAchivUser,// Все достижения
        	'getCompetenct' => $getCompetenct, // Компетенции
        	'varArrayUserEvent' => $arrayEventUser,  // События пользователя
        	'arrayUserCompany' => $arrayUserCompany, // список компаний юузера
        	'getNoti' => $getNoti, // увидомления
            'getSert' => $getSert,
            'getUserSertCustom' => $getUserSertCustom,
            'getSchoolUserMainPage' => $getSchoolUserMainPage,
            'getStudentsInProfile' => $getStudentsInProfile
        ]);
    }

	public function actionProfileedit()
    {
        $arrayEdit = Profileedit::getEdit();
        $arrayComp = Profileedit::getCompAll();
        $arrayUserComp = Profileedit::getCompUser();
        $getSchoolUser = ProfileEdit::getSchoolUser();
        /*return $this->render('EditProfile',[
        	'varArrEditView' => $array,
        	'url' => '/profile/edit-profile',
        	'label' => 'EditProfile'
        ]);*/
        return $this->render('Profileedit',[
        	'varArrEditView' => $arrayEdit,
        	'arrayComp' => $arrayComp,
            'getSchoolUser' => $getSchoolUser,
        	'arrayUserComp' => $arrayUserComp
        ]);
    }


    //Профессии 


    public function actionListstudens() {

        $getStudents = Liststudents::getStudents();

        return $this->render('liststudens', [
            'getStudents' => $getStudents,
        ]);
    }

    public function actionProf() {

    	$arrayProf = Prof::getProf();
    	$arrayProfFavorite = Prof::getFavoriteProf();

    	return $this->render('prof', [
    		'varArrayProf' => $arrayProf,
    		'varArrayProfFavorite' => $arrayProfFavorite,
    	]);
    }

    public function actionViewprof() {
    	$arrayViewProf = Viewprof::getProfDetail(); //Массив с таблицы profession
    	$arrayViewProfOrg = Viewprof::getOrganistation(); //Массив с таблицы organisation
    	$arrayViewProfComp = Viewprof::getCompetenct(); //Массив с таблицы competence
    	$arrayViewProfSlider = Viewprof::getSlide(); // Массив с слайд картинками
    	$arrayViewAddress = Viewprof::getAddres(); // Массив с адресами организаций
    	$arrayFavorite = Viewprof::getFavoriteUser(); //Добавленна ли эта профессия в избарнные

    	return $this->render('viewprof', [
    		'varArrayViewProf' => $arrayViewProf,   //Массив с таблицы profession
    		'varArrayViewProfOrg' => $arrayViewProfOrg,  //Массив с таблицы organisation
    		'varArrayViewProfComp' => $arrayViewProfComp, //Массив с таблицы competence
    		'varArrayViewProfSlider' => $arrayViewProfSlider, // Массив с слайд картинками
    		'varArrayViewAddress' => $arrayViewAddress, // Массив с адресами организаций
    		'getFavoriteUser' => $arrayFavorite // Массив избрана ли эта профессия или нет(добавленна ли в избаранные)
    	]);
    }

    //Где учиться

    public function actionSince() {

    	$arrayVyz = Vyz::getVyz();
    	$arrayOrgFavorite = Vyz::getFavoriteOrg();


    	return $this->render('since', [
    		'varArrayVyz' => $arrayVyz,
    		'varArrayOrgFavorite' => $arrayOrgFavorite,
    	]);
    }

    public function actionSinceview() {

    	$arrayFullsince = Sinceview::getFullSince(); //Массив с таблицы организации
    	$arrayCompSince = Sinceview::getCompetenct(); //Массив с таблицы направления
    	$arrayProfSince = Sinceview::getProf(); //Массив с таблицы профессии
    	$arrayViewSinceSlider = Sinceview::getSlide(); // Массив с слайд картинками
    	$arrayViewAddress = Sinceview::getAdres(); // Массив с адресами организаций
    	$arrayViewFavoriteUserSince = Sinceview::getFavoriteUser(); //Добавлена ли организация в избранные
        $typeOrg = Sinceview::typeOrg();

    	return $this->render('sinceview', [
            'typeOrg' => $typeOrg,
    		'varArrayFullsince' => $arrayFullsince,  //Массив с таблицы организации
    		'varArrayCompSince' => $arrayCompSince, //Массив с таблицы направления
    		'varArrayProfSince' => $arrayProfSince, //Массив с таблицы профессии
    		'varArrayViewSinceSlider' => $arrayViewSinceSlider, // Массив с слайд картинками
    		'varArrayMap' => $arrayViewAddress, // Массив с адресами организаций
    		'varViewFavoriteUserSince' => $arrayViewFavoriteUserSince //Добавлена ли организация в избранные
    	]);
    }


    //Блоги

    public function actionBlog() {

    	$arrayBlog = Blog::getBlog();


    	return $this->render('blog', [
    		'varArrayBlog' => $arrayBlog,
    	]);
    }

    public function actionBlogview() {

        $arrayBlog = Blogview::getBlog();
        $getComment = Blogview::getComment();

        return $this->render('blogview', [
            'varArrayBlog' => $arrayBlog,
            'getComment' => $getComment
        ]);
    }

    public function actionAddcommentblog() {
        if(\Yii::$app->request->isAjax){
            if(isset($_POST['idBlog']) && isset($_POST['commentText'])) {
                $idBlog = (int)$_POST['idBlog'];
                $commentText = $_POST['commentText'];
                $user_id = Yii::$app->user->identity->id;
                $myDate = date('m/d/Y');

                $sql = "SELECT * FROM blog WHERE id = $idBlog";
                $cmd = Yii::$app->db->createCommand($sql)->queryOne();

                if(!empty($cmd) || !empty($commentText)) {
                    $group_user_add = Yii::$app->db->createCommand()->insert('comments', [
                                                                        'id_blog' => $idBlog,
                                                                        'id_user' => $user_id,
                                                                        'comments' => $commentText,
                                                                        'time' => $myDate
                                                                        ])->execute();
                    echo "Комментарий успешно добавлен";
                }
                else {
                    return "Вы не заполнли поле комментарий либо возникла критичиская ошибка!";
                }

            }
        }
    }

    public function actionEditmyblog() {

        $arrayBlog = Editmyblog::getBlog();
        $getComment = Editmyblog::getComment();

        return $this->render('editmyblog', [
            'varArrayBlog' => $arrayBlog,
            'getComment' => $getComment
        ]);
    }


    //Тесты

    public function actionTests() {

    	$arrayTests = Tests::getTests();
    	$arraySlider = Tests::getSlider();


    	return $this->render('tests', [
    		'varArrayTests' => $arrayTests,
    		'sliderArray' => $arraySlider,
    	]);
    }

    public function actionTestedit() {
    		
    		$model = new Testedit();

	    	if(isset($_GET['idTest']) && isset($_GET['OrgID'])) { 
	        	$id = (int)$_GET['idTest'];
	        	$id_org = (int)$_GET['OrgID']; 
	        } 
	        else { 
	        	die('-____- ты как сюда попал?');
	        	return false; 
	        }

	    	if (Yii::$app->request->isPost) {
	            $model->sliderTest = UploadedFile::getInstances($model, 'sliderTest');
	            if(empty($model->sliderTest)) {

	            }
	            else {
		            if ($model->uploadSliderTest($id)) {
		                // file is uploaded successfully
		              
		              
		            }
		            else {
		            	
		            	echo "error slider TEST<br>";
		            }
		        }
	        }

    	$arrayTest = Testedit::getFullTest();
    	$arraySlider = Testedit::getSlider();
    	$arrayOrg = Testedit::getOrg();
    	$getAllCompany = Editmyevent::allOrg();

    	return $this->render('testedit', [
    		'model' => $model,
    		'varArrayTest' => $arrayTest,
    		'varArrayOrg' => $arrayOrg,
    		'sliderArray' => $arraySlider,
    		'getAllCompany' => $getAllCompany
    	]);

    }

    public function actionTestview() {

    	$arrayTest = Testview::getFullTest();
    	$arraySlider = Testview::getSlider();
    	$arrayOrg = Testview::getOrg();
        $arrayUserComplite = Testview::getUserComplite();

    	return $this->render('testview', [
    		'varArrayTest' => $arrayTest,
    		'varArrayOrg' => $arrayOrg,
    		'sliderArray' => $arraySlider,
            'arrayUserComplite' => $arrayUserComplite
    	]);
    }



    //Где работать 

    public function actionJob() {

    	$arrayJob = Job::getJob();
    	$arrayJobFavorite = Job::getJobFavorite();

    	return $this->render('job', [
    		'varArrayJob' => $arrayJob,
    		'varArrayJobFavorite' => $arrayJobFavorite,
    	]);
    }

    public function actionJobview() {

    	$arrayFullJob = Jobview::getFullJob(); //Массив с таблицы организации
    	$arrayProfJob = Jobview::getProf(); //Массив с таблицы профессии
    	$arrayViewJobSlider = Jobview::getSlide(); // Массив с слайд картинками
    	$arrayViewAddress = Jobview::getAdres(); // Массив с адресами организаций
    	$arrayViewFavoriteUserJob = Jobview::getFavoriteUser(); //Добавлена ли организация в избранные
        $typeOrg = Jobview::typeOrg();

    	return $this->render('jobview', [
            'typeOrg' => $typeOrg,
    		'varArrayFullJob' => $arrayFullJob,  //Массив с таблицы организации
    		'varArrayProfJob' => $arrayProfJob, //Массив с таблицы профессии
    		'varArrayViewJobSlider' => $arrayViewJobSlider, // Массив с слайд картинками
    		'varArrayMap' => $arrayViewAddress, // Массив с адресами организаций
    		'arrayViewAddress' => $arrayViewAddress,  // Массив с адресами организаций
    		'varViewFavoriteUserJob' => $arrayViewFavoriteUserJob //Добавлена ли организация в избранные
    	]);
    }

    //Карта
     
    public function actionMap() {

    	$arrayMap = Map::getMap();
    	$arrayProf = Map::getPofNameForFilter();
    	$arrayComp = Map::getCompetenceNameForFilter();
    	$arrayOrg = Map::getOrganisationTypeForFilter();

    	return $this->render('map', [
    		'varArrayMap' => $arrayMap,
    		'varArrayProf' => $arrayProf,
    		'varArrayComp' => $arrayComp,
    		'varArrayOrg' => $arrayOrg
    	]);
    }
    //фильтр для карты
	public $enableCsrfValidation = false;

    public function actionFilter() {

    	if(\Yii::$app->request->isAjax){
    		if(isset($_POST['checkbox_prof'])) {
    			$checkbox_prof = $_POST['checkbox_prof'];
    			$arr_prof = "'".implode("','",$checkbox_prof)."'";
				$arr_prof = str_replace('prof_','',$arr_prof);
    		}
			if(isset($_POST['checkbox_org'])) {
				$checkbox_org = $_POST['checkbox_org'];
				$arr_type_org = "'".implode("','",$checkbox_org)."'";
				$arr_type_org = str_replace('org_','',$arr_type_org);
			}
        	if(isset($_POST['checkbox_comp'])) {
        		$checkbox_comp = $_POST['checkbox_comp'];
        		$arr_comp = "'".implode("','",$checkbox_comp)."'";
				$arr_comp = str_replace('comp_','',$arr_comp);
        	}
        	if(!empty($checkbox_prof) && !empty($checkbox_org) && !empty($checkbox_comp)) {
        		//echo 'Профессии - '.$arr_prof;
        		//echo 'Тип организации -'.$arr_type_org;
				//echo 'Компетенции -'.$arr_comp;

				//НЕ ЗНАЮ ПРАВИЛЬНЫЙ ЛИ ЗАПРОС 

				
				$query = "SELECT org.id, org.name, ad.st_addr, ad.coords, t.name as name_type ,t.id as type_id
					FROM `organisation` as org 
			    RIGHT JOIN organisation_has_address as addr ON  org.id = addr.organisation_id
			    LEFT JOIN address as ad ON addr.address_id = ad.id
			    LEFT JOIN organisation_has_type as ortt ON org.id = ortt.organisation_id
			    LEFT JOIN type as t ON ortt.type_id = t.id
			    LEFT JOIN organisation_has_profession as pr ON org.id = pr.organisation_id
			    LEFT JOIN profession as prof ON pr.profession_id = prof.id
			    LEFT JOIN profession_has_competence as c ON c.profession_id = prof.id
			    LEFT JOIN competence as com ON c.competence_id = com.id
			    WHERE prof.id IN($arr_prof) AND t.id IN($arr_type_org) AND com.id IN($arr_comp)
			    	GROUP BY addr.address_id, addr.organisation_id";

				$cmd = Yii::$app->db->createCommand($query)->queryAll();
				return json_encode($cmd,JSON_UNESCAPED_UNICODE);
        	}
        	else if(!empty($checkbox_prof) && !empty($checkbox_org)) {
        		#echo 'Профессии - '.$arr_prof;
        		#echo 'Тип организации -'.$arr_type_org;
        		$query = "SELECT org.id, org.name, ad.st_addr, ad.coords, t.name as name_type, ,t.id as type_id
        			FROM `organisation` as org 
                RIGHT JOIN organisation_has_address as addr ON  org.id = addr.organisation_id
                LEFT JOIN address as ad ON addr.address_id = ad.id
                LEFT JOIN organisation_has_type as ortt ON org.id = ortt.organisation_id
                LEFT JOIN type as t ON ortt.type_id = t.id
                LEFT JOIN organisation_has_profession as pr ON org.id = pr.organisation_id
                LEFT JOIN profession as prof ON pr.profession_id = prof.id
                LEFT JOIN profession_has_competence as c ON c.profession_id = prof.id
                LEFT JOIN competence as com ON c.competence_id = com.id
                WHERE prof.id IN($arr_prof) AND t.id IN($arr_type_org)
                	GROUP BY addr.address_id, addr.organisation_id";

				$cmd = Yii::$app->db->createCommand($query)->queryAll();

				return json_encode($cmd,JSON_UNESCAPED_UNICODE);
        	}
        	else if(!empty($checkbox_org) && !empty($checkbox_comp)) {
        		#echo 'Тип организации -'.$arr_type_org;
        		#echo 'Компетенции -'.$arr_comp;
                $query = "SELECT org.id, org.name, ad.st_addr, ad.coords , t.name as name_type,t.id as type_id
                	FROM `organisation` as org 
                RIGHT JOIN organisation_has_address as addr ON  org.id = addr.organisation_id
                LEFT JOIN address as ad ON addr.address_id = ad.id
                LEFT JOIN organisation_has_type as ortt ON org.id = ortt.organisation_id
                LEFT JOIN type as t ON ortt.type_id = t.id
                LEFT JOIN organisation_has_profession as pr ON org.id = pr.organisation_id
                LEFT JOIN profession as prof ON pr.profession_id = prof.id
                LEFT JOIN profession_has_competence as c ON c.profession_id = prof.id
                LEFT JOIN competence as com ON c.competence_id = com.id
                WHERE t.id IN($arr_type_org) AND com.id IN($arr_comp)
                	GROUP BY addr.address_id, addr.organisation_id";
        		/*$query = "SELECT organisation_has_type.organisation_id as id_org,address.st_addr as address, address.id as id_addr, organisation.name as org_name, type.name as name_type
				 FROM `organisation_has_type` 
				LEFT JOIN organisation ON organisation.id = organisation_has_type.organisation_id
				LEFT JOIN type ON type.id IN ($arr_type_org)
				LEFT JOIN competence ON competence.id IN ($arr_comp)
				LEFT JOIN organisation_has_address ON organisation_has_address.organisation_id = organisation_has_type.organisation_id
				LEFT JOIN address ON address.id = organisation_has_address.address_id
				WHERE organisation_has_type.type_id IN ($arr_type_org)";*/
				$cmd = Yii::$app->db->createCommand($query)->queryAll();

				return json_encode($cmd,JSON_UNESCAPED_UNICODE);
        	}
        	else if(!empty($checkbox_comp) && !empty($checkbox_prof)) {
        			#echo 'Профессии - '.$arr_prof;
        			#echo 'Компетенции -'.$arr_comp;
                $query = "SELECT org.id, org.name, ad.st_addr, ad.coords , t.name as name_type,t.id as type_id
                	FROM `organisation` as org 
              	RIGHT JOIN organisation_has_address as addr ON  org.id = addr.organisation_id
                LEFT JOIN address as ad ON addr.address_id = ad.id
                LEFT JOIN organisation_has_type as ortt ON org.id = ortt.organisation_id
                LEFT JOIN type as t ON ortt.type_id = t.id
                LEFT JOIN organisation_has_profession as pr ON org.id = pr.organisation_id
                LEFT JOIN profession as prof ON pr.profession_id = prof.id
                LEFT JOIN profession_has_competence as c ON c.profession_id = prof.id
                LEFT JOIN competence as com ON c.competence_id = com.id
                WHERE prof.id IN($arr_prof) AND com.id IN($arr_comp)
                	GROUP BY addr.address_id, addr.organisation_id";
                $cmd = Yii::$app->db->createCommand($query)->queryAll();

                return json_encode($cmd,JSON_UNESCAPED_UNICODE);
        	}
        	else if(!empty($checkbox_prof)) {
        		#echo 'Профессии - '.$arr_prof;
                $query = "SELECT org.id, org.name, ad.st_addr, ad.coords , t.name as name_type,t.id as type_id
                	FROM `organisation` as org 
                RIGHT JOIN organisation_has_address as addr ON  org.id = addr.organisation_id
                LEFT JOIN address as ad ON addr.address_id = ad.id
                LEFT JOIN organisation_has_type as ortt ON org.id = ortt.organisation_id
                LEFT JOIN type as t ON ortt.type_id = t.id
                LEFT JOIN organisation_has_profession as pr ON org.id = pr.organisation_id
                LEFT JOIN profession as prof ON pr.profession_id = prof.id
                LEFT JOIN profession_has_competence as c ON c.profession_id = prof.id
                LEFT JOIN competence as com ON c.competence_id = com.id
                WHERE prof.id IN($arr_prof)
                	GROUP BY addr.address_id, addr.organisation_id";

                $cmd = Yii::$app->db->createCommand($query)->queryAll();

                return json_encode($cmd,JSON_UNESCAPED_UNICODE);
        	}
        	else if(!empty($checkbox_org)) {
        		#echo 'Тип организации -'.$arr_type_org;
                $query = "SELECT org.id, org.name, ad.st_addr, ad.coords,t.name as name_type,t.id as type_id
                	FROM `organisation` as org 
                RIGHT JOIN organisation_has_address as addr ON  org.id = addr.organisation_id
                LEFT JOIN address as ad ON addr.address_id = ad.id
                LEFT JOIN organisation_has_type as ortt ON org.id = ortt.organisation_id
                LEFT JOIN type as t ON ortt.type_id = t.id
                LEFT JOIN organisation_has_profession as pr ON org.id = pr.organisation_id
                LEFT JOIN profession as prof ON pr.profession_id = prof.id
                LEFT JOIN profession_has_competence as c ON c.profession_id = prof.id
                LEFT JOIN competence as com ON c.competence_id = com.id
                WHERE t.id IN($arr_type_org)
                	GROUP BY addr.address_id, addr.organisation_id";

                $cmd = Yii::$app->db->createCommand($query)->queryAll();

                return json_encode($cmd,JSON_UNESCAPED_UNICODE);
        	}
        	else if(!empty($checkbox_comp)) {
        		#echo 'Компетенции -'.$arr_comp;
                $query = "SELECT org.id, org.name, ad.st_addr, ad.coords, t.name as name_type,t.id as type_id
                	FROM `organisation` as org 
                RIGHT JOIN organisation_has_address as addr ON  org.id = addr.organisation_id
                LEFT JOIN address as ad ON addr.address_id = ad.id
                LEFT JOIN organisation_has_type as ortt ON org.id = ortt.organisation_id
                LEFT JOIN type as t ON ortt.type_id = t.id
                LEFT JOIN organisation_has_profession as pr ON org.id = pr.organisation_id
                LEFT JOIN profession as prof ON pr.profession_id = prof.id
                LEFT JOIN profession_has_competence as c ON c.profession_id = prof.id
                LEFT JOIN competence as com ON c.competence_id = com.id
                WHERE com.id IN($arr_comp)
                	GROUP BY addr.address_id, addr.organisation_id";

                $cmd = Yii::$app->db->createCommand($query)->queryAll();

                return json_encode($cmd,JSON_UNESCAPED_UNICODE);
        	}
        	else {
        		//header('Content-Type: application/json');
        		$query = "SELECT organisation_has_address.organisation_id as id, organisation.name as name, address.coords as coords, address.st_addr as st_addr, type.name as type_name, type.id as type_id
			FROM organisation_has_address 
			LEFT JOIN address ON address.id = organisation_has_address.address_id
			LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation_has_address.organisation_id
			LEFT JOIN type ON type.id = organisation_has_type.type_id
			LEFT JOIN organisation ON organisation.id = organisation_has_address.organisation_id
			";
				$data = Yii::$app->db->createCommand($query)->queryAll();
        		 // все метки
        		return json_encode($data,JSON_UNESCAPED_UNICODE);
        		//echo "все метки";
        	}
    	}
	}



    //Добавления професси в избранные
    public function actionFavoriteprofadd() {
    	if(\Yii::$app->request->isAjax){
        	if(isset($_POST['id']) && isset($_POST['userID'])) {
        		$id = (int)$_POST['id'];
        		$userID = (int)$_POST['userID'];

        		$sql = "SELECT * FROM profile_favorite_profession WHERE id_profession = $id AND id_profile = $userID";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(empty($cmd)) {
        			$group_user_add = Yii::$app->db->createCommand()->insert('profile_favorite_profession', [
																		'id_profile' => $userID,
																		'id_profession' => $id,
																		])->execute();
        			echo "Профессия добавлена в избранные!";
        		}
        		else {
        			echo "Хитрый хацкер -___-";
        		}
        		
        	}
	    }
    }

     //Удалении професси с избранные
    public function actionFavoriteprofdel() {
    	if(\Yii::$app->request->isAjax){
        	if(isset($_POST['id']) && isset($_POST['userID'])) {
        		$id = (int)$_POST['id'];
        		$userID = (int)$_POST['userID'];

        		$sql = "SELECT * FROM profile_favorite_profession WHERE id_profession = $id AND id_profile = $userID";
        		$cmd = Yii::$app->db->createCommand()
        					->delete('profile_favorite_profession', 'id_profession = '.$id.'' , 'id_profile = '.$userID )
        					->execute();

        		if($cmd) {
        			
        			echo "Профессия удалена с избраного!";
        		}
        		else {
        			echo "Хитрый хацкер -___-";
        		}
        		
        	}
	    }
    }

    //Добавления организации в избранное
    public function actionFavoriteorgadd() {
    	if(\Yii::$app->request->isAjax){
        	if(isset($_POST['id_org']) && isset($_POST['userID_org'])) {
        		$id = (int)$_POST['id_org'];
        		$userID = (int)$_POST['userID_org'];

        		$sql = "SELECT * FROM profile_favorite_organisation WHERE organisation_id = $id AND profile_id = $userID";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(empty($cmd)) {
        			$group_user_add = Yii::$app->db->createCommand()->insert('profile_favorite_organisation', [
																		'profile_id' => $userID,
																		'organisation_id' => $id,
																		])->execute();
        			echo "Организация добавлена в избранные!";
        		}
        		else {
        			echo "Хитрый хацкер -___-";
        		}
        		
        	}
        	else {
        		echo "error post";
        	}
	    }
	    else {
	    	echo "error ajax";
	    }
    }

     //Удалении организации с избранные
    public function actionFavoriteorgdel() {
    	if(\Yii::$app->request->isAjax){
        	if(isset($_POST['id_job']) && isset($_POST['userID_job'])) {
        		$id = (int)$_POST['id_job'];
        		$userID = (int)$_POST['userID_job'];

        		$sql = "SELECT * FROM profile_favorite_organisation WHERE organisation_id = $id AND profile_id = $userID";
        		$cmd = Yii::$app->db->createCommand()
        					->delete('profile_favorite_organisation', 'organisation_id = '.$id.'' , 'profile_id = '.$userID )
        					->execute();

        		if($cmd) {
        			
        			echo "Организация удалена с избраного!";
        		}
        		else {
        			echo "Хитрый хацкер -___-";
        		}
        		
        	}
	    }
    }


    //Добавления События в избранное
    public function actionFavoriteeventadd() {
    	if(\Yii::$app->request->isAjax){
        	if(isset($_POST['id_event']) && isset($_POST['userID_event'])) {
        		$id = (int)$_POST['id_event'];
        		$userID = (int)$_POST['userID_event'];

        		$sql = "SELECT * FROM profile_favorite_event WHERE id_event = $id AND id_user = $userID";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(empty($cmd)) {
        			$group_user_add = Yii::$app->db->createCommand()->insert('profile_favorite_event', [
																		'id_user' => $userID,
																		'id_event' => $id,
																		])->execute();
        			echo "События добавлена в избранные!";
        		}
        		else {
        			echo "Хитрый хацкер -___-";
        		}
        		
        	}
	    }
    }

     //Удалении События с избранные
    public function actionFavoriteeventdel() {
    	if(\Yii::$app->request->isAjax){
        	if(isset($_POST['id_event']) && isset($_POST['userID_event'])) {
        		$id = (int)$_POST['id_event'];
        		$userID = (int)$_POST['userID_event'];

        		$sql = "SELECT * FROM profile_favorite_event WHERE id_event = $id AND id_user = $userID";
        		$cmd = Yii::$app->db->createCommand()
        					->delete('profile_favorite_event', 'id_event = '.$id.'' , 'id_user = '.$userID )
        					->execute();

        		if($cmd) {
        			
        			echo "События удалена с избраного!";
        		}
        		else {
        			echo "Хитрый хацкер -___-";
        		}
        		
        	}
	    }
    }


    //Конец работы с кнопкой добавления / удаления в избарнное 



    //Моя организация - кабинет


    public function actionMycompany() {

    	$model = new Mycompany();

    	if(isset($_GET['id'])) { 
        	$id = (int)$_GET['id']; 
        } 
        else { 
        	die('-____- ты как сюда попал?');
        	return false; 
        }

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstance($model, 'imageFiles');
            if(empty($model->imageFiles)) {

            }
            else {
	            if ($model->upload($id)) {
	                // file is uploaded successfully
	              
	                
	            }
	            else {
	            	echo $id;
	            	echo "error logo<br>";

	            }
	        }
        }

        if (Yii::$app->request->isPost) {
            $model->bgCompany = UploadedFile::getInstance($model,'bgCompany');
            if(empty($model->bgCompany)) {

            }
            else {
	            if ($model->uploadBg($id)) {
	                // file is uploaded successfully
	                
	              
	            }
	            else {
	            	echo "error bg<br>";
	            }
	        }
        }

        if (Yii::$app->request->isPost) {
        	$request = Yii::$app->request;
        	$post = $request->post(); 

        	if($post['Mycompany']['nameCompany'] && $post['Mycompany']['aboutCompany'] && $post['Mycompany']['idCompany'] && $post['Mycompany']['videoCompany']) {

	        	$companyName = (string)$post['Mycompany']['nameCompany'];
	    		$companyAbout = (string)$post['Mycompany']['aboutCompany'];
	    		$videoCompany = (string)$post['Mycompany']['videoCompany'];
	    		$companyId = (int)$post['Mycompany']['idCompany'];

	        	$model->updateInfoCompany($id,$companyName,$companyAbout,$companyId,$videoCompany);
	       	}
	       	else {
	       		echo "<script>console.log('тут сообщения для формы компании');</script>";
	       	}
        }

        if (Yii::$app->request->isPost) {
            $model->slider = UploadedFile::getInstances($model, 'slider');
            if(empty($model->slider)) {

            }
            else {
	            if ($model->uploadSlider($id)) {
	                // file is uploaded successfully
	               
	              
	            }
	            else {
	            	echo "error slider<br>";
	            }
	        }
        }




        if (Yii::$app->request->isPost) {
        	$request = Yii::$app->request;
        	$post = $request->post(); 

        	if($post['Mycompany']['nameEvent'] && $post['Mycompany']['event_time'] && $post['Mycompany']['aboutEvent'] && $post['Mycompany']['idCompanyForEvent'] && $post['Mycompany']['addrEvent']) {

        		$nameEvent = (string)$post['Mycompany']['nameEvent'];
	        	$event_time = $post['Mycompany']['event_time'];
	    		$aboutEvent = (string)$post['Mycompany']['aboutEvent'];
	    		$idCompanyForEvent = (int)$post['Mycompany']['idCompanyForEvent'];
	    		$addrEvent = (int)$post['Mycompany']['addrEvent'];
	    
	        	$model->createEvent($nameEvent,$event_time,$aboutEvent,$idCompanyForEvent,$addrEvent);
	       	}

	       	else {

				echo "<script>console.log('тут сообщения для формы события');</script>";
	       	}
	       		
	       	
        }

        if (Yii::$app->request->isPost) {
            $model->imageFileEvent = UploadedFile::getInstance($model,'imageFileEvent');
            if(empty($model->imageFileEvent)) {

            }
            else {
	            if ($model->uploadPerwieEvent($id)) {
	                // file is uploaded successfully
	                
	              
	            }
	            else {
	            	echo "error imageFileEvent<br>";
	            }
	        }
        }

        if (Yii::$app->request->isPost) {
            $model->sliderEvent = UploadedFile::getInstances($model, 'sliderEvent');
            if(empty($model->sliderEvent)) {

            }
            else {
	            if ($model->uploadSliderEvent($id)) {
	                // file is uploaded successfully
	               
	              
	            }
	            else {
	            	echo "error sliderEvent<br>";
	            }
	        }
        }



        if(!empty($_POST)) {
       		echo "<script>document.location.reload(true);</script>";
        }

        $getCompanyInfo = Mycompany::getCompanyInfo();
    	$getSlideImg = Mycompany::getSlideImg();
    	$eventCompany = Mycompany::eventCompany();
    	$eventAddrGet = Mycompany::eventAddrGet();
    	$testsCompany = Mycompany::testsCompany();
        $blogCompany = Mycompany::blogCompany();

    	return $this->render('mycompany', [
    		'model' => $model,
    		'arrayCompanyInfo' => $getCompanyInfo,
    		'arraySliderImg' => $getSlideImg,
    		'arrayEventCompany' => $eventCompany,
    		'arrayAddr' => $eventAddrGet,
    		'testsCompany' => $testsCompany,
            'blogCompany' => $blogCompany
    	]);


    }

    public function actionDelitslideimgcomp() {

 		if(\Yii::$app->request->isAjax){
        	if(isset($_POST['id_img']) && isset($_POST['src_img']) && isset($_POST['id_company'])) {
        		$id_img = (int)$_POST['id_img'];
        		$src_img = (string)$_POST['src_img'];
        		$id_company = (int)$_POST['id_company'];


        		if(file_exists($src_img)) { // если иозбражения есть в папке
        			unlink(Yii::$app->basePath . '/web/' . $src_img);

        			$cmd = Yii::$app->db->createCommand()
        					->delete('slider_org', 'id = '.$id_img.'' , 'id_org = '.$id_company )
        					->execute();
        		}
        		else { //если была указана ссылка 

        			$cmd = Yii::$app->db->createCommand()
        					->delete('slider_org', 'id = '.$id_img.'' , 'id_org = '.$id_company )
        					->execute();
        		}
        	

        		if($cmd) {
        			
        			echo "Изображения удаленно!";
        		}
        		else {

        			echo "Хитрый хацкер -___-";
        		}
        		
        	}
	    }   	
    	
    }


    public function actionDeliteventcompany() {
    	if(\Yii::$app->request->isAjax){
        	if(isset($_POST['id_event']) && isset($_POST['id_company'])) {
        		$id_event = (int)$_POST['id_event'];
        		$id_company = (int)$_POST['id_company'];


        		if(file_exists(Yii::$app->basePath .'/web/upload/event/'.$id_event)) { // если иозбражения есть в папке
        			unlink(Yii::$app->basePath . '/web/upload/event/' . $id_event);


        			
        			#$cmd = Yii::$app->db->createCommand()
        			#		->delete('event', 'id = '.$id_event)
        			#		->execute();

        			$cmd = Yii::$app->db->createCommand('DELETE FROM event WHERE id='.$id_event)
       				 ->execute();
        				
        		}
        		else { //если была указана ссылка 

        			#$cmd = Yii::$app->db->createCommand()
        			#		->delete('event', 'id = '.$id_event.'')
        			#		->execute();

        			$cmd = Yii::$app->db->createCommand('DELETE FROM event WHERE id='.$id_event)
       				 ->execute();
        			
        		}
        	

        		if($cmd) {
        			
        			return "Событие удаленно!";
        		}
        		else {

        			return "Хитрый хацкер -___-";
        		}
        		
        	}
	    } 
    }

    public function actionSearchprof() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['search_text'])) {
    			$search_text = (string)$_POST['search_text'];

    			if(strlen($search_text) > 0) {

    				$sql = "SELECT name,img,id,description FROM profession WHERE name LIKE '%$search_text%' OR description LIKE '%$search_text%'";
    				$cmd = Yii::$app->db->createCommand($sql)->queryAll();

    				$result = json_encode($cmd);
    				return $result;
					
    			}
    		}
    	} 
    }
    //Поиск аякс
    public function actionSearchjob() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['search_text'])) {
    			$search_text = (string)$_POST['search_text'];

    			if(strlen($search_text) > 0) {

    				$sql = "SELECT name,img,description,id,organisation_has_type.type_id FROM organisation 
    				 LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation.id
    				 WHERE name LIKE '%$search_text%' OR description LIKE '%$search_text%'";
    				$cmd = Yii::$app->db->createCommand($sql)->queryAll();

    				$result = json_encode($cmd);
    				return $result;
					
    			}
    		}
    	} 
    }

    public function actionSearchsince() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['search_text'])) {
    			$search_text = (string)$_POST['search_text'];

    			if(strlen($search_text) > 0) {

    				$sql = "SELECT name,img,id,description,organisation_has_type.type_id FROM organisation 
    				 LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation.id
    				 WHERE name LIKE '%$search_text%' OR description LIKE '%$search_text%'";
    				$cmd = Yii::$app->db->createCommand($sql)->queryAll();

    				#$cmd = array_unique($cmd);
    				$result = json_encode($cmd);
    				return $result;
					//print_r($cmd);
    			}
    		}
    	} 
    }

    public function actionSearchevent() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['search_text'])) {
    			$search_text = (string)$_POST['search_text'];

    			if(strlen($search_text) > 0) {

    				$sql = "SELECT id,title as name, description,picture as img,event_time as eventTime FROM event 
    				 WHERE title LIKE '%$search_text%' OR description LIKE '%$search_text%'";
    				$cmd = Yii::$app->db->createCommand($sql)->queryAll();

    				$cmd = array_unique($cmd);
    				$result = json_encode($cmd);
    				return $result;
					
    			}
    		}
    	} 
    }

    public function actionSearchtest() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['search_text'])) {
    			$search_text = (string)$_POST['search_text'];

    			if(strlen($search_text) > 0) {

    				$sql = "SELECT * FROM test 
    				 WHERE title LIKE '%$search_text%' OR description LIKE '%$search_text%'";
    				$cmd = Yii::$app->db->createCommand($sql)->queryAll();

    				$cmd = array_unique($cmd);
    				$result = json_encode($cmd);
    				return $result;
					
    			}
    		}
    	} 
    }
    //Редактирования пользователя
    public function actionEdituserajax() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['family']) && isset($_POST['about']) && isset($_POST['schoolUser'])) {
    			$email = (string)$_POST['email'];
    			$name = (string)$_POST['name'];
    			$family = (string)$_POST['family'];
    			$about = (string)$_POST['about'];
                $schoolUser = (int)$_POST['schoolUser'];
    			$id = Yii::$app->user->identity->id;

    			$get_user = "SELECT * FROM user WHERE id = $id";
    			$query_get = Yii::$app->db->createCommand($get_user)->queryOne();
    			$db_uemail = $query_get['email'];
    			$db_uname = $query_get['last_name'];
    			$db_ufamily = $query_get['first_name'];
    			$db_about = $query_get['about'];

    			if(!empty($name) && !empty($family) && !empty($email) && !empty($about)) {
    				$sql = "UPDATE user SET email = '$email' , last_name = '$name' , first_name = '$family' , about = '$about', school = '$schoolUser' WHERE id = '$id'";
		    		Yii::$app->db->createCommand($sql)->execute();
		    		echo "данные успешно обновлены!";
    			}
    			else {	
    				echo "заполните все поля";
    			}
    			
    			
    		}
    	}
    }

    public function actionEditcompuserajax() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['comp_user'])) {
    			$id_user = Yii::$app->user->identity->id;
    			$comp_user = (int)$_POST['comp_user'];

    			$sql = "SELECT * FROM profile_has_competence WHERE profile_id = $id_user AND competence_id = $comp_user";
    			$query = Yii::$app->db->createCommand($sql)->queryOne();

    			if(!empty($query)) {
    				return 'Данная компетенция была уже добавлена!';
    			}
    			else {
    				$add_comp = Yii::$app->db->createCommand()->insert('profile_has_competence', [
																		'profile_id' => $id_user,
																		'competence_id' =>  $comp_user,
																		])->execute();
    				return 'Компетенции успешно добавлена!';
    			}
    			

    		}
    	}
    }

    public function actionDelitcompuserajax() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['del_comp'])) {
    			$id_user = Yii::$app->user->identity->id;
    			$comp_user = (int)$_POST['del_comp'];

    			$sql = "SELECT * FROM profile_has_competence WHERE profile_id = $id_user AND competence_id = $comp_user";
    			$query = Yii::$app->db->createCommand($sql)->queryOne();

    			if(!empty($query)) {
    				$id_row = $query['id'];
    				$delete = Yii::$app->db->createCommand()
        					->delete('profile_has_competence', 'id = '.$id_row )
        					->execute();

    				return 'Компетенции успешно удалена!';
    			}
    			else {
    				
    				return 'Ошибка обращения к базе - данные небыли найдены!';
    			}
    			

    		}
    	}
    }

    public function actionUploadnewavatar() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_FILES['avatar_user'])) {
    			$img = $_FILES['avatar_user'];
    			$tmp_name_img = $img['tmp_name'];
    			$id_user = Yii::$app->user->identity->id;

    			$path = 'upload/profile/'.$id_user;
    			$path_bg = 'upload/profile/'.$id_user.'/avatar';

    			$get_name_file = explode(".",$_FILES["avatar_user"]["name"]);
				$newfilename= uniqid().'.'.end($get_name_file);

				$path_img = $path_bg.'/'.$newfilename;

				$types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
				if (!in_array($_FILES['avatar_user']['type'], $types)) {
					die('Запрещённый тип файла!!');
				}
				else {
					if(!file_exists($path)) {
						#return $path;
	    				mkdir($path, 0755);
	    			}
					if(!file_exists($path_bg)) {
	    				mkdir($path_bg, 0755);

	    				if(move_uploaded_file($tmp_name_img, $path_img)) {
	    					$sql = "UPDATE user SET avatar = '$path_img' WHERE id = '$id_user'";
	    					Yii::$app->db->createCommand($sql)->execute();

	    					return 'Автар успешно загружен';

	    				}
	    				else {
	    					return 'Изображения не было загружено';
	    				}
	    				
	    			}
	    			else {
	    				if(move_uploaded_file($tmp_name_img, $path_img)) {
	    					$sql = "UPDATE user SET avatar = '$path_img' WHERE id = '$id_user'";
	    					Yii::$app->db->createCommand($sql)->execute();

	    					return 'Аватар успешно загружен';
	    				}
	    				else {
	    					return 'Изображения не было загружено!';
	    				}
	    			
	    			}
	    			
				}

    			

    		}
    		else {
    			return 'ошибка загрузки картинки';
    		}
    	} 
    }

    public function actionUploadnewsertportfolio() {
        if(\Yii::$app->request->isAjax) {
            if(isset($_FILES['filePortfolio']) && isset($_POST['titleFilePortfolio'])) {

                $titleFilePortfolio = (string)$_POST['titleFilePortfolio'];
                $img = $_FILES['filePortfolio'];
                $tmp_name_img = $img['tmp_name'];


                $id_user = Yii::$app->user->identity->id;

                $path = 'upload/profile/'.$id_user;
                $path_bg = 'upload/profile/'.$id_user.'/certificate';

                $get_name_file = explode(".",$_FILES["filePortfolio"]["name"]);
                $newfilename= uniqid().'.'.end($get_name_file);

                $path_img = $path_bg.'/'.$newfilename;

                $types = array('image/png', 'image/jpeg', 'image/jpg','application/pdf');
                if (!in_array($_FILES['filePortfolio']['type'], $types)) {
                    die('Запрещённый тип файла!!');
                }
                else {
                    if(!file_exists($path)) {
                        #return $path;
                        mkdir($path, 0755);
                    }
                    if(!file_exists($path_bg)) {
                        mkdir($path_bg, 0755);

                        if(move_uploaded_file($tmp_name_img, $path_img)) {

                            $add_comp = Yii::$app->db->createCommand()->insert('profile_has_portfolio', [
                                                                        'id_user' => $id_user,
                                                                        'title' =>  $titleFilePortfolio,
                                                                        'link' => $path_img
                                                                        ])->execute();

                            return 'Сертификат успешно загружен';

                        }
                        else {
                            return 'Сертификат не был загружен';
                        }
                        
                    }
                    else {
                        if(move_uploaded_file($tmp_name_img, $path_img)) {
                            $add_comp = Yii::$app->db->createCommand()->insert('profile_has_portfolio', [
                                                                        'id_user' => $id_user,
                                                                        'title' =>  $titleFilePortfolio,
                                                                        'link' => $path_img
                                                                        ])->execute();

                            return 'Сертификат успешно загружен';
                        }
                        else {
                            return 'Сертификат не был загружен';
                        }
                    
                    }
                    
                }

                

            }
            else {
                return 'ошибка загрузки сертификата';
            }
        } 
    }

    public function actionDelcertuser() {
        if(\Yii::$app->request->isAjax) {
            if(isset($_POST['idCertDelUser'])) {
                $delcertuserID = $_POST['idCertDelUser'];
                $id_user = Yii::$app->user->identity->id;

                $sql = "SELECT * FROM profile_has_portfolio WHERE id_user = $id_user AND id = $delcertuserID";
                $cmd = Yii::$app->db->createCommand($sql)->queryOne();
                $link = $cmd['link'];

                if(file_exists($link)) {
                    unlink($link);
                    $delete = Yii::$app->db->createCommand()
                            ->delete('profile_has_portfolio', 'id_user = '.$id_user.'' , 'id = '.$delcertuserID )
                            ->execute();
                    return 'Сертификат успешно удален!';
                }
                else {
                    $delete = Yii::$app->db->createCommand()
                            ->delete('profile_has_portfolio', 'id_user = '.$id_user.'' , 'id = '.$delcertuserID )
                            ->execute();
                    return 'Сертификат успешно удален!';
                }

            }
            else {
                return 'Не передан id сертификата';
            }
        } 
        else {
            return 'Проблема с ajax request';
        }      
    }

    //события компании - редактирование
    public function actionEditmyevent() {
    	if(empty(Yii::$app->user->identity->id)) {
    		echo "<script>window.location = '/';</script>";
    	}
    	else {

    		$model = new Editmyevent();

	    	if(isset($_GET['idEvent']) && isset($_GET['OrgID'])) { 
	        	$id = (int)$_GET['idEvent'];
	        	$id_org = (int)$_GET['OrgID']; 
	        } 
	        else { 
	        	die('-____- ты как сюда попал?');
	        	return false; 
	        }

	    	if (Yii::$app->request->isPost) {
	            $model->sliderEvent = UploadedFile::getInstances($model, 'sliderEvent');
	            if(empty($model->sliderEvent)) {

	            }
	            else {
		            if ($model->uploadSliderEvent($id)) {
		                // file is uploaded successfully
		              
		              
		            }
		            else {
		            	
		            	echo "error sliderEvent<br>";
		            }
		        }
	        }

	    	$getinfoevent = Editmyevent::getEvent();
	    	$getsliderevent = Editmyevent::getSlide();

	    	$arrayOrg = Editmyevent::getOrg(); 
	    	$arrayViewAddress = Editmyevent::getAdres(); // Массив с адресами организаций

	    	$getAllAdress = Editmyevent::getAllAdress();
	    	$getAllCompany = Editmyevent::allOrg();

	    	return $this->render('editmyevent', [
	    		'model' => $model,
	    		'arrayEventInfo' => $getinfoevent,
	    		'arrayEventSlider' => $getsliderevent,
	    		'arrayOrg' => $arrayOrg,
	    		'arrayViewAddress' => $arrayViewAddress,
	    		'getAllAdress' => $getAllAdress,
	    		'getAllCompany' => $getAllCompany,

	    	]);

    	}
    }

    public function actionUpdateevent() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['nameEvent']) && isset($_POST['descriptionEditEvent']) && isset($_POST['idEvent']) && isset($_POST['event_time'])) {
    			
    			$event_time = (string)$_POST['event_time'];
    			$nameEvent = (string)$_POST['nameEvent'];
    			$descriptionEditEvent = (string)$_POST['descriptionEditEvent'];
    			$idEvent = (int)$_POST['idEvent'];
    			
    			$sql = "UPDATE event SET title = '$nameEvent' , description = '$descriptionEditEvent', event_time = '$event_time' WHERE id = '$idEvent'";
		    	Yii::$app->db->createCommand($sql)->execute();

		    	return 'Основная инофрмация обновлена!';
    		}
    	} 
    }

    public function actionUploadnewbgevent() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_FILES['bgevent']) && isset($_POST['ideventbg'])) {
    			$img = $_FILES['bgevent'];
    			$id_event = (int)$_POST['ideventbg'];
    			$tmp_name_img = $img['tmp_name'];

    			$path = 'upload/event/'.$id_event;
    			$path_bg = 'upload/event/'.$id_event.'/bg';

    			$get_name_file = explode(".",$_FILES["bgevent"]["name"]);
				$newfilename= uniqid().'.'.end($get_name_file);

				$path_img = $path_bg.'/'.$newfilename;


    			if(!file_exists($path)) {
    				mkdir($path,0755);
    				#FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
    			}

    			if(!file_exists($path_bg)) {
    				#FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
    				mkdir($path,0755);
    				if(move_uploaded_file($tmp_name_img, $path_img)) {
    					$sql = "UPDATE event SET picture = '$path_img' WHERE id = '$id_event'";
    					Yii::$app->db->createCommand($sql)->execute();

    					return 'Главная картинка была успешно обновлена';

    				}
    				else {
    					return 'Изображения не было загружено';
    				}
    				
    			}
    			else {
    				if(move_uploaded_file($tmp_name_img, $path_img)) {
    					$sql = "UPDATE event SET picture = '$path_img' WHERE id = '$id_event'";
    					Yii::$app->db->createCommand($sql)->execute();

    					return 'Главная картинка была успешно обновлена';
    				}
    				else {
    					return 'Изображения не было загружено!';
    				}
    			
    			}

    		}
    		else {
    			return 'ошибка загрузки картинки';
    		}
    	} 
    }

    public function actionUploadnewslide() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_FILES['slider']) && isset($_POST['ideventslider'])) {
    			$img = $_FILES['slider'];
    			$id_event = (int)$_POST['ideventslider'];
    			$tmp_name_img = $img['tmp_name'];

    			$path = 'upload/event/'.$id_event;
    			$path_bg = 'upload/event/'.$id_event.'/slider';

    			

				#$path_img = $path_bg.'/'.$newfilename;

				$total = count($_FILES['slider']['name']);
				
				if(!file_exists($path)) {
    				FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
    			}


    			if(!file_exists($path_bg)) {
    				FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

    				for($i=0; $i<$total; $i++) {
				
						$tmpFilePath = $_FILES['slider']['tmp_name'][$i];
						$get_name_file = explode(".",$_FILES["slider"]["name"][$i]);
						$newfilename= uniqid().'.'.end($get_name_file);

						if ($tmpFilePath != ""){

					    	$newFilePath = $path_bg."/" . $newfilename;

					   
					   			if(move_uploaded_file($tmpFilePath, $newFilePath)) {

					    		$addSliderEvent = Yii::$app->db->createCommand()->insert('slider_event', [
																		'id_event' => $id_event,
																		'img' =>  $newFilePath,
																		])->execute();

    							return '!Загрузка завершена успешно!';

							    }
							    else {
							    	return 'Ошибка перемешения в постоянный каталог!';
							    }

					  	}

					}
    				
    				
    			}
    			else {

    				for($i=0; $i<$total; $i++) {
				
						$tmpFilePath = $_FILES['slider']['tmp_name'][$i];
						$get_name_file = explode(".",$_FILES["slider"]["name"][$i]);
						$newfilename= uniqid().'.'.end($get_name_file);

						if ($tmpFilePath != ""){

					    	$newFilePath = $path_bg."/" . $newfilename;

					   	
					   			if(move_uploaded_file($tmpFilePath, $newFilePath)) {

					    		$addSliderEvent = Yii::$app->db->createCommand()->insert('slider_event', [
																		'id_event' => $id_event,
																		'img' =>  $newFilePath,
																		])->execute();

    							return '!Загрузка завершена успешно!';

							    }
							    else {
							    	return 'Ошибка перемешения в постоянный каталог!';
							    }

					  	}

					}
    			
    			}



    		}
    		else {
    			$data= Yii::$app->request->post();
    			return 'ошибка Ajax - слайдер';
    		}
    	} 
    }

    public function actionDelitslideevent() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['edit_slide_del_id']) && isset($_POST['edit_slide_del_event_id']) && isset($_POST['name_slide_del'])) {
    			$idEvent = $_POST['edit_slide_del_event_id'];
    			$idSlide = $_POST['edit_slide_del_id'];
    			$imgName = $_POST['name_slide_del'];

    			if(file_exists($imgName)) {
    				unlink($imgName);
    				$delete = Yii::$app->db->createCommand()
        					->delete('slider_event', 'id = '.$idSlide.'' , 'id_event = '.$idEvent )
        					->execute();
        			return 'Слайд успешно удален!';
    			}
    			else {
    				$delete = Yii::$app->db->createCommand()
        					->delete('slider_event', 'id = '.$idSlide.'' , 'id_event = '.$idEvent )
        					->execute();
        			return 'Слайд успешно удален!';
    			}

    		}
    	}

    }

    public function actionMainpageslide() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_event_slide']) && isset($_POST['id_slide'])) {
    			$id_event = $_POST['id_event_slide'];
    			$id_slide = $_POST['id_slide'];

    			$sql = "SELECT * FROM slider_event WHERE id_event = $id_event AND event_main_page = 1";
    			$cmd = Yii::$app->db->createCommand($sql)->queryOne();

    			if(!empty($cmd)) {
    				$id_slide_cmd = $cmd['id'];
    				$sql = "UPDATE slider_event SET event_main_page = '0' WHERE id = '$id_slide_cmd'";
    				Yii::$app->db->createCommand($sql)->execute();

    				$query = "UPDATE slider_event SET event_main_page = '1' WHERE id = '$id_slide'";
    				Yii::$app->db->createCommand($query)->execute();

    				return 'Слайд добален на главную';
    			}
    			else {
    				$sql = "UPDATE slider_event SET event_main_page = '1' WHERE id = '$id_slide'";
    				Yii::$app->db->createCommand($sql)->execute();

    				return 'Слайд добален на главную';
    			}
    		}
    	}
    }

    public function actionMainpageslidedel() {
     	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_event_slide_del']) && isset($_POST['id_slide_del'])) {
    			$id_event = $_POST['id_event_slide_del'];
    			$id_slide = $_POST['id_slide_del'];

    			$sql = "UPDATE slider_event SET event_main_page = '0' WHERE id = '$id_slide'";
    			Yii::$app->db->createCommand($sql)->execute();

    			return 'Слайд  убран с главной страницы';
    		}
    		else {
    			return 'Ошибка передачи данных post';
    		}
    	} 
    	else {
    		return 'ошибка ajax';
    	}  	
    }


    public function actionDelitcompanyevent() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_event_del']) && isset($_POST['id_org_del'])) {
    			$idEvent = (int)$_POST['id_event_del'];
    			$id_org = (int)$_POST['id_org_del'];

    			$sql = "SELECT * FROM event_has_organisation WHERE id_org = $id_org AND id_event = $idEvent";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(!empty($cmd)) {
        			$deleteaddresevent = Yii::$app->db->createCommand()
        					->delete('event_has_organisation', 'id_org = '.$id_org.'' , 'id_event = '.$idEvent )
        					->execute();
        			return "Организация успешно удалена";
        		}
        		else {
        			
        			return "Такая компания не найдена в базе события!";
        		}
    		}
    	} 
    }

    public function actionDelitaddresevent() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_event_del']) && isset($_POST['id_addr_del'])) {
    			$idEvent = (int)$_POST['id_event_del'];
    			$id_addr = (int)$_POST['id_addr_del'];

    			$sql = "SELECT * FROM event_has_address WHERE event_id = $idEvent AND address_id = $id_addr";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(!empty($cmd)) {
        			$id = $cmd['id'];
        			$deleteaddresevent = Yii::$app->db->createCommand()
        					->delete('event_has_address', 'id = '.$id )
        					->execute();
        			return "Адрес события успешно удален";
        		}
        		else {
        			
        			return "Такой адрес не найден в базе события!";
        		}
    		}
    	} 
    }

    public function actionAddaddresevent() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_event']) && isset($_POST['id_addr'])) {
    			$idEvent = (int)$_POST['id_event'];
    			$id_addr = (int)$_POST['id_addr'];

    			$sql = "SELECT * FROM event_has_address WHERE event_id = $idEvent AND address_id = $id_addr";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(empty($cmd)) {
        			$addaddresevent = Yii::$app->db->createCommand()->insert('event_has_address', [
																		'event_id' => $idEvent,
																		'address_id' => $id_addr,
																		])->execute();
        			return "Адрес события успешно добавлен";
        		}
        		else {
        			return "Такой адрес уже добавлен на карту";
        		}
    		}
    	} 
    }


    public function actionAddcompanyinevent() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_event']) && isset($_POST['id_orgevent'])) {
    			$idEvent = (int)$_POST['id_event'];
    			$id_orgevent = (int)$_POST['id_orgevent'];

    			$sql = "SELECT * FROM event_has_organisation WHERE id_org = $id_orgevent AND id_event = $idEvent";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(empty($cmd)) {
        			$addaddresevent = Yii::$app->db->createCommand()->insert('event_has_organisation', [
																		'id_org' => $id_orgevent,
																		'id_event' => $idEvent,
																		])->execute();
        			return "Организация успешно добавлена к событию";
        		}
        		else {
        			return "Такая организация уже была добавлена";
        		}
    		}
    		else {
    			return "ошибка селект - организации!";
    		}
    	}     	
    }

    # Notification  

    public function actionAddnoti() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['idEventNoti']) && isset($_POST['userIDnoti'])) {
    			$idEventNoti = (int)$_POST['idEventNoti'];
    			$userIDnoti = (int)$_POST['userIDnoti'];

    			$sql = "SELECT * FROM profile_has_notification WHERE id_user = $userIDnoti AND id_event = $idEventNoti";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(empty($cmd)) {
        			$addaddresevent = Yii::$app->db->createCommand()->insert('profile_has_notification', [
																		'id_user' => $userIDnoti,
																		'id_event' => $idEventNoti,
																		])->execute();
        			return "Вы успешно подписались на оповещения";
        		}
        		else {
        			return "Вы уже были подписаны на оповещения";
        		}
    		}
    		else {
    			return "Ошибка поиска в базе - оповещения";
    		}
    	}     	
    }

    public function actionDelitnoti() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['idEventNoti_del']) && isset($_POST['userIDnoti_del'])) {
    			$idEventNoti_del = (int)$_POST['idEventNoti_del'];
    			$userIDnoti_del = (int)$_POST['userIDnoti_del'];

    			$sql = "SELECT * FROM profile_has_notification WHERE id_event = $idEventNoti_del AND id_user = $userIDnoti_del";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(!empty($cmd)) {
        			$id = $cmd['id'];
        			$deleteaddresevent = Yii::$app->db->createCommand()
        					->delete('profile_has_notification', 'id = '.$id )
        					->execute();
        			return "Вы успешно отказались от оповещения";
        		}
        		else {
        			
        			return "Ошибка поиска в базе - оповещения";
        		}
    		}
    	} 
    }


    public function actionIsreednoti() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['idEventNoti']) && isset($_POST['is_reed'])) {
    			$idEventNoti = (int)$_POST['idEventNoti'];
    			$user_id = Yii::$app->user->identity->id;

    			$find = "SELECT * FROM profile_has_notification WHERE id_user = $user_id AND id_event = $idEventNoti";
    			$sql_find = Yii::$app->db->createCommand($find)->queryOne();

    			$sql_find_status = $sql_find['is_reed'];
    			$sql_finde_id = $sql_find['id'];

    			if($sql_find_status == 0) {
    				$sql = "UPDATE profile_has_notification SET is_reed = 1 WHERE id = '$sql_finde_id'";
		    		Yii::$app->db->createCommand($sql)->execute();

		    		return 'Все прошло успешно!';
    			}
    			else {
    				return 'Ошибка - это уведомление уже было прочитано!';
    			}

    		}
    	}
    }

    public function actionNewtests() {
    	if(\Yii::$app->request->isAjax) {

    		if(isset($_POST['idcompany']) && isset($_POST['testArray']) && isset($_FILES['bgtest']) && isset($_POST['title']) && isset($_POST['timeTest']) && isset($_POST['description']) && isset($_POST['rating']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
    		
    			$img = $_FILES['bgtest'];
    			$tmp_name_img = $img['tmp_name'];


    		
    			$idCompany = (int)$_POST['idcompany'];

    			$title = $_POST['title'];
    			$description = $_POST['description'];
    			$rating = $_POST['rating'];
    			$timeTest = $_POST['timeTest'];
    			$startDate = $_POST['startDate'];
    			$endDate = $_POST['endDate'];
    			
    			#$newArray = array_splice($_POST['testArray'], 7);
    			$jsonFinal = $_POST['testArray'];

    			$query = "INSERT INTO test (organisation,
    										title,
    										description,
    										ArrayWithQuerstion,
    										timeTest,
    										exp,
    										data_start,
    										data_end) VALUES 
    										(
    										'$idCompany',
    										'$title',
											'$description',
											'$jsonFinal',
											'$timeTest',
											'$rating',
											'$startDate',
											'$endDate'
    										)";

               	$cmd = Yii::$app->db->createCommand($query)->execute();
    			

    			$id = Yii::$app->db->getLastInsertID();
    			$path = 'upload/tests/'.$id;
    			$path_bg = 'upload/tests/'.$id.'/bg';

    			$group_user_add = Yii::$app->db->createCommand()->insert('organisation_has_test', [
																		'id_org' => $idCompany,
																		'id_test' => $id,
																		])->execute();


    			$get_name_file = explode(".",$_FILES["bgtest"]["name"]);
				$newfilename= uniqid().'.'.end($get_name_file);

				$path_img = $path_bg.'/'.$newfilename;

				$types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
				if (!in_array($_FILES['bgtest']['type'], $types)) {
					die('Запрещённый тип файла!!');
				}
				else {
					if(!file_exists($path)) {
						#return $path;
	    				mkdir($path, 0755);
	    			}
					if(!file_exists($path_bg)) {
	    				mkdir($path_bg, 0755);

	    				if(move_uploaded_file($tmp_name_img, $path_img)) {
	    					$sql = "UPDATE test SET img = '$path_img' WHERE id = '$id'";
	    					Yii::$app->db->createCommand($sql)->execute();

	    					//return 'good';

	    				}
	    				else {
	    					//return 'Изображения не было загружено';
	    				}
	    				
	    			}
	    			else {
	    				if(move_uploaded_file($tmp_name_img, $path_img)) {
	    					$sql = "UPDATE test SET img = '$path_img' WHERE id = '$id'";
	    					Yii::$app->db->createCommand($sql)->execute();

	    					//return 'Аватар успешно загружен';
	    				}
	    				else {
	    					//return 'Изображения не было загружено!';
	    				}
	    			
	    			}
	    			
				}

				return 'Тест добален';
    
				
    		}
    		else {
    			echo "bad ajax";
    		}

    	}


    }


    #Тесты - редактирование

    public function actionAddcompanyintest() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_test']) && isset($_POST['id_orgtest'])) {
    			$id_test = (int)$_POST['id_test'];
    			$id_orgtest = (int)$_POST['id_orgtest'];

    			$sql = "SELECT * FROM organisation_has_test WHERE id_org = $id_orgtest AND id_test = $id_test";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(empty($cmd)) {
        			$addaddresevent = Yii::$app->db->createCommand()->insert('organisation_has_test', [
																		'id_org' => $id_orgtest,
																		'id_test' => $id_test,
																		])->execute();
        			return "Организация успешно добавлена к тесту";
        		}
        		else {
        			return "Такая организация уже была добавлена";
        		}
    		}
    		else {
    			return "ошибка селект - организации!";
    		}
    	}     	
    }
    

    public function actionDelitcompanytest() {
		if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_test_del']) && isset($_POST['id_org_del'])) {
    			$id_test = (int)$_POST['id_test_del'];
    			$id_org = (int)$_POST['id_org_del'];

    			$sql = "SELECT * FROM organisation_has_test WHERE id_org = $id_org AND id_test = $id_test";
        		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

        		if(!empty($cmd)) {
        			$deleteaddresevent = Yii::$app->db->createCommand()
        					->delete('organisation_has_test', 'id_org = '.$id_org.'' , 'id_test = '.$id_test )
        					->execute();
        			return "Организация успешно удалена";
        		}
        		else {
        			
        			return "Такая компания не найдена в базе события!";
        		}
    		}
    	} 
    }

    public function actionMainpageslidetest() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_test_slide']) && isset($_POST['id_slide'])) {
    			$id_test = $_POST['id_test_slide'];
    			$id_slide = $_POST['id_slide'];

    			$sql = "SELECT * FROM slider_test WHERE id_test = $id_test AND test_main_page = 1";
    			$cmd = Yii::$app->db->createCommand($sql)->queryOne();

    			if(!empty($cmd)) {
    				$id_slide_cmd = $cmd['id'];
    				$sql = "UPDATE slider_test SET test_main_page = '0' WHERE id = '$id_slide_cmd'";
    				Yii::$app->db->createCommand($sql)->execute();

    				$query = "UPDATE slider_test SET test_main_page = '1' WHERE id = '$id_slide'";
    				Yii::$app->db->createCommand($query)->execute();

    				return 'Слайд добален на главную';
    			}
    			else {
    				$sql = "UPDATE slider_test SET test_main_page = '1' WHERE id = '$id_slide'";
    				Yii::$app->db->createCommand($sql)->execute();

    				return 'Слайд добален на главную';
    			}
    		}
    	}
    }

    public function actionMainpageslidedeltest() {
     	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['id_test_slide_del']) && isset($_POST['id_slide_del'])) {
    			$id_test = $_POST['id_test_slide_del'];
    			$id_slide = $_POST['id_slide_del'];

    			$sql = "UPDATE slider_test SET test_main_page = '0' WHERE id = '$id_slide'";
    			Yii::$app->db->createCommand($sql)->execute();

    			return 'Слайд  убран с главной страницы';
    		}
    		else {
    			return 'Ошибка передачи данных post';
    		}
    	} 
    	else {
    		return 'ошибка ajax';
    	}  	
    }

     public function actionDelitslidtest() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['edit_slide_del_id']) && isset($_POST['edit_slide_del_test_id']) && isset($_POST['name_slide_del'])) {
    			$idTest = $_POST['edit_slide_del_test_id'];
    			$idSlide = $_POST['edit_slide_del_id'];
    			$imgName = $_POST['name_slide_del'];

    			if(file_exists($imgName)) {
    				unlink($imgName);
    				$delete = Yii::$app->db->createCommand()
        					->delete('slider_test', 'id = '.$idSlide.'' , 'id_test = '.$idTest )
        					->execute();
        			return 'Слайд успешно удален!';
    			}
    			else {
    				$delete = Yii::$app->db->createCommand()
        					->delete('slider_test', 'id = '.$idSlide.'' , 'id_test = '.$idTest )
        					->execute();
        			return 'Слайд успешно удален!';
    			}

    		}
    	}

    }

    public function actionEdittest() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['idTest']) && isset($_POST['nameTest']) && isset($_POST['descriptionTest']) && isset($_POST['exp']) && isset($_POST['timeTest']) && isset($_POST['dataStart']) && isset($_POST['dataEnd']) && isset($_POST['certifikat'])) {

    			$idTest = (int)$_POST['idTest'];
    			$nameTest = (string)$_POST['nameTest'];
    			$descriptionTest = (string)$_POST['descriptionTest'];
    			$exp = (int)$_POST['exp'];
    			$timeTest = (string)$_POST['timeTest'];
    			$dataStart = (string)$_POST['dataStart'];
    			$dataEnd = (string)$_POST['dataEnd'];
    			$certifikat = (int)$_POST['certifikat'];

    			$sql = "UPDATE test SET title = '$nameTest', 
    									description = '$descriptionTest', 
    									timeTest = '$timeTest', 
    									exp = '$exp', 
    									certificate = '$certifikat', 
    									data_start = '$dataStart', 
    									data_end = '$dataEnd' 
    									WHERE id = '$idTest'";

    			Yii::$app->db->createCommand($sql)->execute();

    			return 'Данные успешно обновлены!';

    		}
    		else {
    			return 'Один из главных парраметров не был передан';
    		}
    	}
    	else {
    		return 'Ошибка Ajax! ';
    	}
    }

    public function actionEditquestiontest() {
    	if(\Yii::$app->request->isAjax) {
    		if(isset($_POST['idTest']) && isset($_POST['testArray'])) {

    			$idTest = (int)$_POST['idTest'];
    			$testArray =  $_POST['testArray'];
    			
    			$sql = "UPDATE test SET ArrayWithQuerstion = '$testArray' 
    									WHERE id = ".$idTest;

    			Yii::$app->db->createCommand($sql)->execute();

    			return 'Данные успешно обновлены!';

    		}
    		else {
    			return 'Один из главных парраметров не был передан';
    		}
    	}
    	else {
    		return 'Ошибка Ajax! ';
    	}    	
    }

    public function actionEditmainimagetest() {
    	if (\Yii::$app->request->isAjax) {
    		if (isset($_POST['idTest']) && isset($_FILES['bgtestedit'])) {

    			
    			$img = $_FILES['bgtestedit'];
    			$tmp_name_img = $img['tmp_name'];

    			$id = $_POST['idTest'];


    			$find_sql = "SELECT * FROM test WHERE id = '$id'";
    			$send_sql = Yii::$app->db->createCommand($find_sql)->queryOne();
    			$current_img = $send_sql['img'];

    			if(!empty($current_img)) { unlink($current_img); } 


    			$path = 'upload/tests/'.$id;
    			$path_bg = 'upload/tests/'.$id.'/bg';

    		
    			$get_name_file = explode(".",$_FILES["bgtestedit"]["name"]);
				$newfilename= uniqid().'.'.end($get_name_file);

				$path_img = $path_bg.'/'.$newfilename;

				$types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
				if (!in_array($_FILES['bgtestedit']['type'], $types)) {
					die('Запрещённый тип файла!!');
				}
				else {
					if(!file_exists($path)) {
						#return $path;
	    				mkdir($path, 0755);
	    			}
					if(!file_exists($path_bg)) {
	    				mkdir($path_bg, 0755);

	    				if(move_uploaded_file($tmp_name_img, $path_img)) {
	    					$sql = "UPDATE test SET img = '$path_img' WHERE id = '$id'";
	    					Yii::$app->db->createCommand($sql)->execute();

	    					return 'Фон был успешно загружен';

	    				}
	    				else {
	    					return 'Изображения не было загружено';
	    				}
	    				
	    			}
	    			else {
	    				if(move_uploaded_file($tmp_name_img, $path_img)) {
	    					$sql = "UPDATE test SET img = '$path_img' WHERE id = '$id'";
	    					Yii::$app->db->createCommand($sql)->execute();

	    					return 'Фон был успешно загружен';
	    				}
	    				else {
	    					return 'Изображения не было загружено!';
	    				}
	    			
	    			}
	    			
				}
    		}
    		else {
    			return 'Ошибка post - один из парраметров не был передан';
    		}
    	}
    	else {
    		return  'Ошибка Ajax';
    	}
    }


  	public function actionDelittest() {
  		if (\Yii::$app->request->isAjax) {
    		if (isset($_POST['idTest']) && isset($_POST['id_company'])) {
    			$id = $_POST['idTest'];
    			$idCompany = $_POST['id_company'];

    			$sql = "SELECT * FROM test WHERE id = '$id' AND organisation = '$idCompany'";
    			$send_sql = Yii::$app->db->createCommand($sql)->queryOne();

    			if(!empty($send_sql)) {
    				if(file_exists('upload/tests/'.$id)) { // если иозбражения есть в папке
        				if(file_exists('upload/tests/'.$id)) {
                            unlink('upload/tests/' . $id);
        					$delit= Yii::$app->db->createCommand()
        						->delete('test', 'id = '.$id )
        						->execute();
        					return 'Удаление прошло успешно';

        				}
        				else {
        					$path = 'upload/tests/' . $id;
        					return 'Не удалось удалить каталог - '.$path;;
        				}
        			}
        			else {
        				$delit= Yii::$app->db->createCommand()
        					->delete('test', 'id = '.$id )
        					->execute();
        				return 'Удаление прошло успешно';
        			}

    			}
    			else {
    				return 'Один из парраметров не соответсвует запросу на удаление - у вас нет доступа к данном тесту!';
    			}
    			
    		}
    		else {
    			return 'Ошибка post - один из парраметров не был передан';
    		}
    	}
    	else {
    		return  'Ошибка Ajax';
    	}
  	}

    protected function get_tiny_permalink($certificateRequestUrl) {
        $QR = file_get_contents("https://tinyurl.com/api-create.php?url=".$certificateRequestUrl);
        return $QR;
    }

  	public function actionUsertestsend() {
  		if (\Yii::$app->request->isAjax) {
    		if (isset($_POST['idTest']) && isset($_POST['arrayWithAnswer'])) {
    				
    				$idTest = (int)$_POST['idTest'];
    				$answerUser = '{"tests":'.$_POST['arrayWithAnswer'].'}';

    				$sql = "SELECT * FROM test WHERE id = '$idTest'";
    				$send_sql = Yii::$app->db->createCommand($sql)->queryOne();
                    $certificateGet = $send_sql['certificate']; 
                    $expTest = (int)$send_sql['exp'];


                    $userIdExp = Yii::$app->user->identity->id;
                    $sqlGetExp = "SELECT * FROM profile WHERE id_users = '$userIdExp'";
                    $send_sqlGetExp = Yii::$app->db->createCommand($sqlGetExp)->queryOne();
                    $exp = (int)$send_sqlGetExp['expirience']; 
                    $exp = $exp + $expTest;

                    $sqlUpdExp = "UPDATE profile SET expirience =  '$exp' WHERE id_users = '$userIdExp'";
                    Yii::$app->db->createCommand($sqlUpdExp)->execute();

                    $sqlCountTestUser = "SELECT * FROM TestCompliteUser WHERE idUser = '$userIdExp'";
                    $send_sqlCountTestUser = Yii::$app->db->createCommand($sqlCountTestUser)->queryAll();
                    $countTest = count($send_sqlCountTestUser);
                    
                    if($countTest == 0) {
                        $insertAchive = Yii::$app->db->createCommand()->insert('profile_has_achievement', [
                                                                            'profile_id' => $userIdExp,
                                                                            'achievement_id' => '3'
                                                                            ])->execute(); 
                    }
                    if($countTest == 4) {
                        $insertAchive = Yii::$app->db->createCommand()->insert('profile_has_achievement', [
                                                                            'profile_id' => $userIdExp,
                                                                            'achievement_id' => '4'
                                                                            ])->execute();    
                    }

    				$testSystem = '{"tests":'.$send_sql['ArrayWithQuerstion'].'}';

    				$objTestMainArray = json_decode($testSystem); 
					$objTestUserArray = json_decode($answerUser);

					$testMainArray = $objTestMainArray->tests;
					$testUserArray = $objTestUserArray->tests;

					$arrayUser = array();
					$arrayMain = array();	

					$badOtvet = array();
    				$goodOtvet = array();

					$i = 1;
					$k = 1;
					
					foreach ($testUserArray as $key => $userJson) {
						$key_count = (int)$key;
						if ($key_count == 0) continue;

						$givevariant = $userJson->givevariant;
						$arrayUser[$i] = array("otvet" => $givevariant);			
						$i++;
					}

					foreach ($testMainArray as $key => $mainJson) {
						$key_count = (int)$key;
						if ($key_count == 0) continue;

						$truevariant = $mainJson->truevariant;
						$arrayMain[$k] = array("otvet" => $truevariant);	
						$k++;		
					}

					#$intersection = array_intersect($arrayUser, $arrayMain);
					#echo 'Результат array_intersect: '.json_encode($intersection);
    				
    				if($arrayUser == $arrayMain) {
    					//100% совпадения
    					//var_dump($arrayUser);
    					//var_dump($arrayMain);
    					$user_id = Yii::$app->user->identity->id;
    					$getFirstName = Yii::$app->user->identity->first_name;
    					$getLastName = Yii::$app->user->identity->last_name;
    					$getUsername = Yii::$app->user->identity->username;
    					$goodOtvetJson = json_encode($arrayUser);

    					if(!empty($getFirstName) && !empty($getLastName)) {
    						$companyId = $send_sql['organisation'];
    						$userName = $getFirstName.' '.$getLastName;

    						$getTestCompliteUser = "SELECT * FROM TestCompliteUser WHERE id_test = '$idTest' AND idUser = '$user_id'";
    						$sqlSendTestCompliteUser = Yii::$app->db->createCommand($getTestCompliteUser)->queryOne();


    						if(!empty($sqlSendTestCompliteUser)) {
    							return 'Вы уже прошли тест!';
    						}
    						else {
	    						$insertTestCompliteUser = Yii::$app->db->createCommand()->insert('TestCompliteUser', [
																			'id_test' => $idTest,
																			'idUser' => $user_id,
																			'goodOtvet' => $goodOtvetJson
																			])->execute(); 
                                
                                $certificateRequestUrl = "https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id;
                                $certificatePage = file_get_contents($certificateRequestUrl);

                                $qrLink = $this->get_tiny_permalink($certificateRequestUrl);

                                if(!empty($certificateGet)) {
                                    #file_get_contents("https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id);

                                    $sqlTableLink = "SELECT * FROM user_link_certificate WHERE id_user = '$user_id' AND id_test = '$idTest'";
                                    $getLink = Yii::$app->db->createCommand($sqlTableLink)->queryOne();
                                    $certificateRequestUrlQR = $getLink['link_certificate'];
                                }
	    						#$certificateRequestUrl = "https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id;

	    						#$certificatePage = file_get_contents($certificateRequestUrl);

                                if(!empty($certificateGet)) {
	    						     return '
                                     <a href="'.$certificateRequestUrl.'" class="btn btn-info" style="display:none;" download>Скачать</a>
                                        <div class="embed-responsive embed-responsive-16by9" style="display:none;">
                                            <iframe class="embed-responsive-item" src="'.$certificateRequestUrl.'"></iframe>
                                         </div>
                        
                                       

                                        <div class="qr-code"><p style="display:none;">Вы так же можете скачать сертификат используя QR-код</p>
                                        <img style="display:none;" src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$qrLink.'" class="img img-thumbnail" />
										</div>
										
                                         <script>$("iframe").ready(function (){ location.reload(); });</script>
                                    ';
                                }
                                else {
                                    return '<p> Вы успешно прошли тест! </p>';
                                }

	    					}


    					}
    					else {
							$companyId = $send_sql['organisation'];
    						$userName = $getUsername;
    						
    						$getTestCompliteUser = "SELECT * FROM TestCompliteUser WHERE id_test = '$idTest' AND idUser = '$user_id'";
    						$sqlSendTestCompliteUser = Yii::$app->db->createCommand($getTestCompliteUser)->queryOne();
    						if(!empty($sqlSendTestCompliteUser)) {
    							return 'Вы уже прошли тест!';
    						}
    						else {
	    						$insertTestCompliteUser = Yii::$app->db->createCommand()->insert('TestCompliteUser', [
																			'id_test' => $idTest,
																			'idUser' => $user_id,
																			'goodOtvet' => $goodOtvetJson
																			])->execute(); 

                                $certificateRequestUrl = "https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id;
                                $certificatePage = file_get_contents($certificateRequestUrl);
                                
                                $qrLink = $this->get_tiny_permalink($certificateRequestUrl);

                                if(!empty($certificateGet)) {
                                    #file_get_contents("https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id);

                                     $sqlTableLink = "SELECT * FROM user_link_certificate WHERE id_user = '$user_id' AND id_test = '$idTest'";
                                    $getLink = Yii::$app->db->createCommand($sqlTableLink)->queryOne();
                                    $certificateRequestUrlQR = $getLink['link_certificate'];
                                }
	    						#$certificatePage = file_get_contents($certificateRequestUrl);
	    						if(!empty($certificateGet)) {
                                     return '
                                     
                                     <a href="'.$certificateRequestUrl.'" class="btn btn-info" style="display:none;" download>Скачать</a>
                                        <div class="embed-responsive embed-responsive-16by9" style="display:none;">
                                            <iframe class="embed-responsive-item" src="'.$certificateRequestUrl.'"></iframe>
                                         </div>
                        
                                       

                                        <div class="qr-code"><p style="display:none;">Вы так же можете скачать сертификат используя QR-код</p>
                                        <img style="display:none;" src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$qrLink.'" class="img img-thumbnail" />
										</div>
                                        <script>$("iframe").ready(function (){ location.reload(); });</script>
    
                                    ';
                                }
                                else {
                                    return '<p> Вы успешно прошли тест! </p>';
                                }
	    						
	    					}

    					}
    				}
    				else {
    					//Ищем совпадения

    					$countMain = count($arrayMain);
    					$countUser = count($arrayUser);
    					
    					if($countMain >= $countUser) {
    						$countMass = $countMain;
    					} else {
    						$countMass = $countUser; 
    					}
    					for ($i=1; $i <= $countMass; $i++) { 
    						if($arrayMain[$i] == $arrayUser[$i]){
    							#echo "внутренние на шаги $i равны ",PHP_EOL;
    							// формируем если правильный
    							$goodOtvet[$i] = $arrayMain[$i];

    						} else {
    							$badOtvet[$i] = $arrayUser[$i];
    							#if(count($arrayMain[$i]["otvet"]) >= count($arrayUser[$i]["otvet"])) {
    							#	$countArr = count($arrayMain[$i]["otvet"]);
    							#} else {
    							#	$countArr = count($arrayUser[$i]["otvet"]);
    							#}
                                #echo "countArr = $countArr ",PHP_EOL;
    							#for ($j=0; $j <= $countArr-1; $j++) { 
    							#	echo"сдесь формирую не совпадение $i $j ",PHP_EOL;
    								// формируем если не правильный условие ниже формирует прицип отличие 
                                #    if($arrayMain[$i]["otvet"][$j]){
                                        #echo "в исходнике значение = ".$arrayMain[$i]["otvet"][$j]." ",PHP_EOL;

                                #    } else {
                                        #echo "в исходнике нету элемента c индексом $i $j ",PHP_EOL;
                                        #$detailBadOtvet[$i] = $arrayUser[$i]["otvet"][$j];

                                #    }
    								//$arrayMain[$i]["otvet"][$j]; обращение к элементу        
    							#} 
    						}
    					}

    					$user_id = Yii::$app->user->identity->id;
    					$getFirstName = Yii::$app->user->identity->first_name;
    					$getLastName = Yii::$app->user->identity->last_name;
    					$getUsername = Yii::$app->user->identity->username;
    					
    					$goodOtvetJson = json_encode($goodOtvet);
    					$badOtvetJson = json_encode($badOtvet);

    					if(!empty($getFirstName) && !empty($getLastName)) {
    						$companyId = $send_sql['organisation'];
    						$userName = $getFirstName.' '.$getLastName;

    						$getTestCompliteUser = "SELECT * FROM TestCompliteUser WHERE id_test = '$idTest' AND idUser = '$user_id'";
    						$sqlSendTestCompliteUser = Yii::$app->db->createCommand($getTestCompliteUser)->queryOne();
    						if(!empty($sqlSendTestCompliteUser)) {
    							return 'Вы уже прошли тест!';
    						}
    						else {
	    						$insertTestCompliteUser = Yii::$app->db->createCommand()->insert('TestCompliteUser', [
																			'id_test' => $idTest,
																			'idUser' => $user_id,
																			'goodOtvet' => $goodOtvetJson,
																			'badOtvet' => $badOtvetJson
																			])->execute(); 
                                $certificateRequestUrl = "https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id;
                                $certificatePage = file_get_contents($certificateRequestUrl);
                                $qrLink = $this->get_tiny_permalink($certificateRequestUrl);

                                if(!empty($certificateGet)) {
                                    #file_get_contents("https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id);

                                     $sqlTableLink = "SELECT * FROM user_link_certificate WHERE id_user = '$user_id' AND id_test = '$idTest'";
                                    $getLink = Yii::$app->db->createCommand($sqlTableLink)->queryOne();
                                    $certificateRequestUrlQR = $getLink['link_certificate'];
                                }
	    						#$certificatePage = file_get_contents($certificateRequestUrl);
	    						if(!empty($certificateGet)) {
                                     return '
                                     <a href="'.$certificateRequestUrl.'" class="btn btn-info" style="display:none;" download>Скачать</a>
                                        <div class="embed-responsive embed-responsive-16by9" style="display:none;">
                                            <iframe class="embed-responsive-item" src="'.$certificateRequestUrl.'"></iframe>
                                         </div>
                        
                                        

                                        <div class="qr-code"><p style="display:none;">Вы так же можете скачать сертификат используя QR-код</p>
                                        <img style="display:none;" src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$qrLink.'" class="img img-thumbnail" />
										</div>
                                         <script>$("iframe").ready(function (){ location.reload(); });</script>
                                    ';
                                }
                                else {
                                    return '<p> Вы успешно прошли тест! </p>';
                                }

	    					}


    					}
    					else {
							$companyId = $send_sql['organisation'];
    						$userName = $getUsername;
    						
    						$getTestCompliteUser = "SELECT * FROM TestCompliteUser WHERE id_test = '$idTest' AND idUser = '$user_id'";
    						$sqlSendTestCompliteUser = Yii::$app->db->createCommand($getTestCompliteUser)->queryOne();
    						if(!empty($sqlSendTestCompliteUser)) {
    							return 'Вы уже прошли тест!';
    						}
    						else {
	    						$insertTestCompliteUser = Yii::$app->db->createCommand()->insert('TestCompliteUser', [
																			'id_test' => $idTest,
																			'idUser' => $user_id,
																			'goodOtvet' => $goodOtvetJson,
																			'badOtvet' => $badOtvetJson
																			])->execute(); 
                                

	    						$certificateRequestUrl = "https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id;
                                $certificatePage = file_get_contents($certificateRequestUrl);
                                $qrLink = $this->get_tiny_permalink($certificateRequestUrl);

                                if(!empty($certificateGet)) {
                                    #file_get_contents("https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id);

                                    $sqlTableLink = "SELECT * FROM user_link_certificate WHERE id_user = '$user_id' AND id_test = '$idTest'";
                                    $getLink = Yii::$app->db->createCommand($sqlTableLink)->queryOne();
                                    $certificateRequestUrlQR = $getLink['link_certificate'];
                                }
	    						
	    						if(!empty($certificateGet)) {
                                     return '
                                     <a href="'.$certificateRequestUrl.'" class="btn btn-info" style="display:none;" download>Скачать</a>
                                        <div class="embed-responsive embed-responsive-16by9" style="display:none;">
                                            <iframe class="embed-responsive-item" src="'.$certificateRequestUrl.'"></iframe>
                                         </div>
                        
                                        

                                        <div class="qr-code"><p style="display:none;">Вы так же можете скачать сертификат используя QR-код</p>
                                        <img style="display:none;" src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$qrLink.'" class="img img-thumbnail" />
										</div>
                                        <script>$("iframe").ready(function (){ location.reload(); });</script>
                                      
                                    ';
                                }
                                else {
                                    return '<p> Вы успешно прошли тест! </p>';
                                }
	    						
	    					}

    					}
    					

    					#return "Верные ответы: ".json_encode($goodOtvet)." - Не верные ответы: ".json_encode($badOtvet)." - Детализации по неправильным ответам: ".json_encode($detailBadOtvet);

    				}
    		}
    	}
  	}

    public function actionGetcertificate() {
       if (\Yii::$app->request->isAjax) {
            if (isset($_POST['idTest'])) {

                $idTest = (int)$_POST['idTest'];

                $getTestCompliteUser = "SELECT * FROM TestCompliteUser WHERE id_test = '$idTest' AND idUser = '$user_id'";
                $sqlSendTestCompliteUser = Yii::$app->db->createCommand($getTestCompliteUser)->queryOne();
                
                $sql = "SELECT * FROM test WHERE id = '$idTest'";
                $send_sql = Yii::$app->db->createCommand($sql)->queryOne();

                $user_id = Yii::$app->user->identity->id;
                $getFirstName = Yii::$app->user->identity->first_name;
                $getLastName = Yii::$app->user->identity->last_name;
                $getUsername = Yii::$app->user->identity->username;

                if(!empty($getFirstName) && !empty($getLastName)) {
                    $userName = $getFirstName.' '.$getLastName;
                    $companyId = $send_sql['organisation'];

                    #$certificateRequestUrl = "https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id;
                    $sqlTableLink = "SELECT * FROM user_link_certificate WHERE id_user = '$user_id' AND id_test = '$idTest'";
                    $getLink = Yii::$app->db->createCommand($sqlTableLink)->queryOne();
                    
                    $certificateRequestUrl = $getLink['link_certificate'];
                    return '
                      <a href="'.$certificateRequestUrl.'" class="btn btn-info" download>Скачать</a>
                        <div class="embed-responsive embed-responsive-16by9">
                          <object class="embed-responsive-item" data="'.$certificateRequestUrl.'"></object>
                        </div>
                        

                          <div class="qr-code"><p>Вы так же можете скачать сертификат используя QR-код</p>
                          <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$certificateRequestUrl.'" class="img img-thumbnail" />
						  </div>
                    ';
                }
                else {
                    $userName = $getUsername;
                    $companyId = $send_sql['organisation'];

                    #$certificateRequestUrl = "https://profinavigator.ru/certificate/certificate_main/screen.php?idCompany=".$companyId."&idTest=".$idTest."&userName=".$userName."&userID=".$user_id;;
                     $sqlTableLink = "SELECT * FROM user_link_certificate WHERE id_user = '$user_id' AND id_test = '$idTest'";
                    $getLink = Yii::$app->db->createCommand($sqlTableLink)->queryOne();
                    $certificateRequestUrl = $getLink['link_certificate'];
                    #print_r($getLink);
                    return '
                        <a href="'.$certificateRequestUrl.'" class="btn btn-info" download>Скачать</a>
                        <div class="embed-responsive embed-responsive-16by9">
                          <object class="embed-responsive-item" data="'.$certificateRequestUrl.'"></object>
                        </div>

                          
        
                          <div class="qr-code"><p>Вы так же можете скачать сертификат используя QR-код</p>
                          <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$certificateRequestUrl.'" class="img img-thumbnail" />
						  </div>
                    ';
                }
            }   
        } 
    }


//Новый пост

    public function actionNewblog() {
        if(\Yii::$app->request->isAjax) {

            if(isset($_POST['idcompany']) && isset($_POST['titleBlog']) && isset($_POST['textBlog']) & isset($_FILES['bgblog'])) {
            
                $img = $_FILES['bgblog'];
                $tmp_name_img = $img['tmp_name'];

            
                $idCompany = (int)$_POST['idcompany'];

                $titleBlog = $_POST['titleBlog'];
                $textBlog = $_POST['textBlog'];
                $myDate = date('m/d/Y');
                
                $query = "INSERT INTO blog (title,
                                            description,
                                            data) VALUES 
                                            ('$titleBlog',
                                            '$textBlog',
                                            '$myDate')";

                $cmd = Yii::$app->db->createCommand($query)->execute();

                $id = Yii::$app->db->getLastInsertID();
        
                $path = 'upload/blog/'.$id;
                $path_bg = 'upload/blog/'.$id.'/bg';

                $get_name_file = explode(".",$_FILES["bgblog"]["name"]);
                $newfilename= uniqid().'.'.end($get_name_file);

                $path_img = $path_bg.'/'.$newfilename;

                $types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
                if (!in_array($_FILES['bgblog']['type'], $types)) {
                    die('Запрещённый тип файла!!');
                }
                else {
                    if(!file_exists($path)) {
                        #return $path;
                        mkdir($path, 0755);
                    }
                    if(!file_exists($path_bg)) {
                        mkdir($path_bg, 0755);

                        if(move_uploaded_file($tmp_name_img, $path_img)) {

                            $group_user_add = Yii::$app->db->createCommand()->insert('organisation_has_blog', [
                                                                        'id_blog' => $id,
                                                                        'id_org' => $idCompany,
                                                                        ])->execute();


                            $sql = "UPDATE blog SET img = '$path_img'  WHERE id = '$id'";
                            Yii::$app->db->createCommand($sql)->execute();
                            //return 'good';

                        }
                        else {
                            //return 'Изображения не было загружено';
                        }
                        
                    }
                    else {
                        if(move_uploaded_file($tmp_name_img, $path_img)) {
                            $sql = "UPDATE blog SET img = '$path_img'  WHERE id = '$id'";
                            Yii::$app->db->createCommand($sql)->execute();
                            
                            $group_user_add = Yii::$app->db->createCommand()->insert('organisation_has_blog', [
                                                                        'id_org' => $idCompany,
                                                                        'id_blog' => $id,
                                                                        ])->execute();

                            //return 'Аватар успешно загружен';
                        }
                        else {
                            //return 'Изображения не было загружено!';
                        }
                    
                    }
                    
                }

                return 'Блог добален';
    
                
            }
            else {
                echo "bad ajax";
            }

        }

    }

    public function actionDelblog() {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['idBlog']) && isset($_POST['id_company'])) {
                $id = $_POST['idBlog'];
                $idCompany = $_POST['id_company'];

                $sql = "SELECT * FROM blog
                        LEFT JOIN organisation_has_blog ON organisation_has_blog.id_org = '$idCompany' 
                        WHERE blog.id = '$id'";
                $send_sql = Yii::$app->db->createCommand($sql)->queryOne();

                if(!empty($send_sql)) {
                    if(file_exists(Yii::$app->basePath .'/web/upload/blog/'.$id)) { // если иозбражения есть в папке
                        
                        if(file_exists(Yii::$app->basePath .'/web/upload/blog/'.$id)) {
                            unlink(Yii::$app->basePath . '/web/upload/blog/' . $id);
                            $delit= Yii::$app->db->createCommand()
                                ->delete('blog', 'id = '.$id )
                                ->execute();
                            return 'Удаление прошло успешно';

                        }
                        else {
                            $path = Yii::$app->basePath . '/web/upload/blog/' . $id;
                            return 'Не удалось удалить каталог - '.$path;;
                        }
                    }
                    else {
                        $delit= Yii::$app->db->createCommand()
                            ->delete('blog', 'id = '.$id )
                            ->execute();
                        return 'Удаление прошло успешно';
                    }

                }
                else {
                    return 'Один из парраметров не соответсвует запросу на удаление - у вас нет доступа к данном блогу!';
                }
                
            }
            else {
                return 'Ошибка post - один из парраметров не был передан';
            }
        }
        else {
            return  'Ошибка Ajax';
        }
    }


    public function actionEditblog() {
        if(\Yii::$app->request->isAjax) {
            if(isset($_POST['titleBlog']) && isset($_POST['textBlogs']) && isset($_POST['idBlog']) && isset($_POST['orgId'])) {
                $title = (string)$_POST['titleBlog'];
                $description = $_POST['textBlogs'];
                $idBlog = (int)$_POST['idBlog'];
                $OrgID = (int)$_POST['orgId'];

                $blog_sql = "SELECT * FROM organisation_has_blog WHERE id_org = $OrgID";
                $query_get = Yii::$app->db->createCommand($blog_sql)->queryOne();

                if(!empty($query_get)) {
                    $sql = "UPDATE blog SET title = '$title' , description = '$description' WHERE id = '$idBlog'";
                    Yii::$app->db->createCommand($sql)->execute();
                    echo "данные успешно обновлены!";
                }
                else {  
                    echo "заполните все поля";
                }
                
                
            }
        }
    }

    public function actionDelitcommentblog() {
         if(\Yii::$app->request->isAjax) {
            if(isset($_POST['idBlog']) && isset($_POST['idComment']) && isset($_POST['orgId'])) {
                $idComment = (int)$_POST['idComment'];
                $idBlog = (int)$_POST['idBlog'];
                $OrgID = (int)$_POST['orgId'];

                $blog_sql = "SELECT * FROM organisation_has_blog WHERE id_org = $OrgID";
                $query_get = Yii::$app->db->createCommand($blog_sql)->queryOne();

                if(!empty($query_get)) {

                    $cmd = Yii::$app->db->createCommand()
                            ->delete('comments', 'id = '.$idComment.'' , 'id_blog = '.$idBlog )
                            ->execute();
                    if($cmd) {
                        echo "Комментарий успешно удален!";
                    }
                    else {
                        return "Не получилось удалить комментарий!".$idComment." - ".$idBlog;
                    }
                }
                else {  
                    echo "Что то пошло не так обратитесь к администрации портала!";
                }
                
                
            }
        }
    }


    public function actionUploadnewbgblog() {
        if(\Yii::$app->request->isAjax) {
            if(isset($_FILES['bgblog']) && isset($_POST['idblogbg'])) {
                $img = $_FILES['bgblog'];
                $id_blog = (int)$_POST['idblogbg'];
                $tmp_name_img = $img['tmp_name'];

                $path = 'upload/blog/'.$id_blog;
                $path_bg = 'upload/blog/'.$id_blog.'/bg';

                $get_name_file = explode(".",$_FILES["bgblog"]["name"]);
                $newfilename= uniqid().'.'.end($get_name_file);

                $path_img = $path_bg.'/'.$newfilename;


                if(!file_exists($path)) {
                    mkdir($path,0755);
                    #FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
                }

                if(!file_exists($path_bg)) {
                    #FileHelper::createDirectory($path_bg, $mode = 0775, $recursive = true);
                    
                    mkdir($path_bg,0755);
                    if(move_uploaded_file($tmp_name_img, $path_img)) {

                        //$pathForBase = 'upload/blog/'.$newfilename;

                        $sql = "UPDATE blog SET img = '$path_img' WHERE id = '$id_blog'";
                        Yii::$app->db->createCommand($sql)->execute();

                        return 'Главная картинка была успешно обновлена';

                    }
                    else {
                        return 'Изображения не было загружено';
                    }
                    
                }
                else {
                    if(move_uploaded_file($tmp_name_img, $path_img)) {
                        $sql = "UPDATE blog SET img = '$path_img' WHERE id = '$id_blog'";
                        Yii::$app->db->createCommand($sql)->execute();

                        return 'Главная картинка была успешно обновлена';
                    }
                    else {
                        return 'Изображения не было загружено!';
                    }
                
                }

            }
            else {
                return 'ошибка загрузки картинки';
            }
        } 
    }


    public function actionTeacheraddrole() {
        if (\Yii::$app->request->isAjax) {
            if(isset($_POST['emailteach']) && isset($_POST['passwordteach']) && isset($_POST['orgwork'])) {
                $emailteach = $_POST['emailteach'];
                $passwordteach = $_POST['passwordteach'];
                $orgwork = $_POST['orgwork'];

                $hashPWD = Yii::$app->getSecurity()->generatePasswordHash($passwordteach);

                $getUser = "SELECT * FROM user WHERE  email =  '$emailteach'";
                $sqlGet = Yii::$app->db->createCommand($getUser)->queryOne();

                if (Yii::$app->getSecurity()->validatePassword($passwordteach, $sqlGet['password_hash'])) {
                
                    if(!empty($sqlGet)) {
                        $id = (int)$sqlGet['id'];
                        $getGroup = "SELECT * FROM user_has_group WHERE user_id = '$id' AND group_id = 3";
                        $sqlGroup = Yii::$app->db->createCommand($getGroup)->queryOne();

                        $getPersonality = "SELECT * FROM organisation_has_personality WHERE personality_id = '$id'";
                        $sqlPersonality = Yii::$app->db->createCommand($getPersonality)->queryOne();

                        if(empty($sqlGroup)) {
                            $query = "INSERT INTO user_has_group(user_id,group_id) VALUES ('$id',3)";
                            Yii::$app->db->createCommand($query)->execute();
                        }
                        else {
                            $query = "UPDATE user_has_group SET group_id = 3 WHERE user_id = ".$id;
                            Yii::$app->db->createCommand($query)->execute();
                        }
                        if(empty($sqlPersonality)) {
                            $query2 = "INSERT INTO organisation_has_personality(organisation_id, personality_id, type_personality) VALUES ('$orgwork','$id',1)";
                            Yii::$app->db->createCommand($query2)->execute();
                        }

                        return 'Роль успешно присовена, войдите в ваш аккаунт <a href="/login" class="btn btn-primary">Войти</a>';
                    }
                    else {
                        return 'Пользователь с такими данными ненайден, если вы уверены в том что вы ввели все верно обратитесь в службу поддеркжи - navigator@adtspb.ru !'.$getUser;
                    }

                } 
                else {
                    return 'Вы указали не верный пароль';
                }

            }
            else {
                return 'Ошибка POST!'.$_POST;
            }
        }
        else {
            return  'Ошибка Ajax';
        }
    }



    public function actionResetpasswordajax() {
        if (\Yii::$app->request->isAjax) {
            if(isset($_POST['emailResetPwd'])) {
                $email = strtolower($_POST['emailResetPwd']);
                
                $getUser = "SELECT * FROM user WHERE  email =  '$email'";
                $sqlGet = Yii::$app->db->createCommand($getUser)->queryOne();
            
                if(!empty($sqlGet)) {
                    $password = uniqid();
                    $password = md5(microtime() . rand(0, 9999));
                    $hash = Yii::$app->getSecurity()->generatePasswordHash($password);

                    $session = Yii::$app->session;
                    #$_SESSION['newpwd'] = $hash;
                    $session->set('newpwd', $hash);
                    $session->set('emailreset', $email);
                    #$_SESSION['emailreset'] = $email;

                    mail($email, 'Сброс пароля - profinavigator.ru', 'Что бы задать пароль нажмите на <a href="https://profinavigator.ru/resetpassword?hash='.$hash.'">эту ссылку</a> если вы не запрашивали сброс пароля то проигнорируйте данное сообщение!');
                    return 'На вашу почту была отпралвенна ссылка для востановления пароля';
                }
                else {
                    return 'Пользователь с таким email не найден!';
                }
            }
            else {
                 return 'Ошибка POST!'.$_POST;
            }
        }
        else {
            return  'Ошибка Ajax';
        }
    }

    public function actionResetpasswordajaxfinal() {
         if (\Yii::$app->request->isAjax) {
            if(isset($_POST['passwordnew']) && isset($_POST['hash'])) {
                
                $session = Yii::$app->session;

                $pwd = $_POST['passwordnew'];
                $hashForm = $_POST['hash'];
                $hashSession = $session->get('newpwd');
                $email = $session->get('emailreset');

                $getUser = "SELECT * FROM user WHERE  email =  '$email'";
                $sqlGet = Yii::$app->db->createCommand($getUser)->queryOne();
            
                if(!empty($sqlGet)) {
                   if($hashForm == $hashSession) {
                        $newpass = Yii::$app->getSecurity()->generatePasswordHash($pwd);
                        $query = "UPDATE user SET password_hash = '$newpass' WHERE email = '$email'";
                        Yii::$app->db->createCommand($query)->execute();

                        return 'Данные успешно обновлены!';
                   }
                   else {
                        return 'Доступ запрещен!';
                   }
                }
                else {
                    return 'Пользователь с таким email не найден!';
                }
            }
            else {
                 return 'Ошибка POST!'.$_POST;
            }
        }
        else {
            return  'Ошибка Ajax';
        }       
    }
}




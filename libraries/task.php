<?php

/**
 * Class Vr360Task
 */
class Vr360Task
{
	/**
	 *
	 */
	public static function login()
	{
		$authorise = Vr360Authorise::getInstance();
		$authorise->login();
	}

	public static function logout()
	{
		$authorise = Vr360Authorise::getInstance();
		$authorise->logout();
	}

	/**
	 * Create new tour
	 */
	public static function createTour()
	{
		Vr360HelperAjax::validate();

		// Ajax verify
		$ajax = new Vr360AjaxResponse();

		// Permission verify
		if (!Vr360Authorise::isLogged())
		{
			$ajax = new Vr360AjaxResponse();
			$ajax->setMessage('User is not logged')->fail()->respond();
		}

		$step = $_POST['step'];

		switch ($step)
		{
			case 'upload':
				Vr360ModelTour::getInstance()->ajaxCreateTour();
				break;

			case 'generate':
				Vr360ModelTour::getInstance()->ajaxGenerateTour();
				break;
			case 'data-update-only':
				//this use when you only need to rebuild xml only
				//like when you edit the hotspots/sences data only
				/*
						$uId = $_POST['uId'];
						$jsonFile = "_/$uId/data.json";
						$jsonOldData = json_decode(file_get_contents($jsonFile), true); //check if cant read file OR cant read json format?

						//update db; allow update only some field
								Vr360Database::getInstance()->insert_vtour([
									'name'       => $_POST['name'],
									'alias'      => $_POST['alias'], //alias must be uniq
								]);
						//update json file
							//bla bla bla bla
						//update xml file
							Vr360HelperTour::xmlCreate($uId, $jsonData);
						*/
				break;
			default:
				//??????
				$ajax->setMessage('Unknow step!')->fail()->respond();
				break;
		}

	}

	public static function getEditTourHtml()
	{
		$ajax = new Vr360AjaxResponse;

    $data = file_get_contents("./_/".$_POST['uId']."/data.json");  //uhm, maybe need to load uid from db..//

    $data = $data ? json_decode($data, true) : $ajax->setMessage('Cant read: data JSON')->fail()->respond();

    $layoutData = [];
    $layoutData['vTourName']  = $data['name'];
    $layoutData['vTourAlias'] = $data['alias'];

		$html = Vr360Layout::fetch('body.user.form.tour', $layoutData);

		$ajax->setData('html', $html)->setData('jsonData', $data)->success()->respond();
	}

	public static function resetPassword()
	{

	}

	public static function removeTour()
	{
		$model = Vr360ModelTour::getInstance();
		$model->ajaxRemoveTour();
	}
}

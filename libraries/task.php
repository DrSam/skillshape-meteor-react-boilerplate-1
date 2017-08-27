<?php

/**
 * Created by PhpStorm.
 * User: soulevil
 * Date: 8/11/17
 * Time: 8:31 PM
 */
class Vr360Task
{
	/**
	 *
	 */
	public static function login()
	{
		$authorise = Vr360Authorise::getInstance();
		$authorise->signIn();
	}

	/**
	 *
	 */
	public static function getTours()
	{
		$auth = Vr360Authorise::getInstance();
		if (!$auth->isAuth())
		{
			echo '{"error": "notAuth"}';
			die();
		}

		$tours = Vr360Database::getInstance()->getTours($auth->getUserId());

		header('Content-Type: application/json');
		echo json_encode($tours, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

		exit();
	}

	public static function unpublished()
	{
		$auth = Vr360Authorise::getInstance();
		if (!$auth->isAuth())
		{
			echo '{"error": "notAuth"}';
			die();
		}

		$db = Vr360Database::getInstance();
		$result = $db->change_vtour_status($_GET['UIDx'], VR360_TOUR_STATUS_UNPUBLISHED);

		header('Content-Type: application/json');
		echo (json_encode(array(
			'status' => ($result !== false) ? true : false
		)));

		exit();
	}

	public static function createTour()
	{

		if (!Vr360Authorise::isLogged())
		{
			echo '{"error": "notAuth"}';
			die();
		}

		$step = $_POST['step'];

		switch ($step)
		{
			case 'upload':
				// File upload and validate
				break;
			case 'create':
				// Save to database
				break;
			case 'generate':
				// Generate tour via exec
				break;
		}

		$uId = uniqid('__', false);
		$uId .= '_' . md5(uniqid('', true));

		$tour_url = $_POST['tour_url'];

		$_data           = new dataVerObj($uId, $auth);
		$_data->tour_url = $tour_url;

		$database = Vr360Database::getInstance();
		$database->check_url(array(
			'alias'    => $tour_url,
			"vtour_id" => 0
		));

		if (isset($tour_result) && $tour_result != "")
		{

		}
		else
		{
			// TODO Move validate data into data class instead
			// TODO Need to check where are requests came from
			// TODO Need to use task for each request and use this one as a part of checking
			if (!empty($_POST['tour_des']))
			{
				if ($database->insert_vtour_1(array(
					'userId'   => $auth->getUserId(),
					'UID'      => $uId,
					"tour_des" => $_data->tourDes,
					"tour_url" => $tour_url
				)))
				{
					$_files = new fileObj($_data);

					$_files->writeAll();
				}
			}
		}
	}
}
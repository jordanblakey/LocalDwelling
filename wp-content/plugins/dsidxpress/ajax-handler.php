<?php
add_action( 'wp_ajax_dsidx_client_assist', array('dsSearchAgent_AjaxHandler', 'handleAjaxRequest') );
add_action( 'wp_ajax_nopriv_dsidx_client_assist', array('dsSearchAgent_AjaxHandler', 'handleAjaxRequest') );
add_action( 'init', array('dsSearchAgent_AjaxHandler', 'localizeScripts') );

class dsSearchAgent_AjaxHandler {
	static public function handleAjaxRequest(){
		if(!empty($_REQUEST['dsidx_action'])){
			dsSearchAgent_AjaxHandler::call($_REQUEST['dsidx_action']);
		}
		else{
			wp_die();
		}
	}
    static function call($method){ 
        if(method_exists('dsSearchAgent_AjaxHandler', $method)) { 
			call_user_func(array('dsSearchAgent_AjaxHandler', $method));
        }else{ 
        	die();
        } 
    } 
    static function localizeScripts(){
		wp_localize_script( 'dsidx', 'dsidxAjaxHandler', array('ajaxurl'=>admin_url( 'admin-ajax.php' )) );
	}
	static function SlideshowXml(){
		$uriSuffix = '';
		if (array_key_exists('uriSuffix', $_GET))
			$uriSuffix = $_GET['uriSuffix'];

		$urlBase = $_GET['uriBase'];

		if (!preg_match("/^http:\/\//", $urlBase))
			$urlBase = "http://" . $urlBase;
		$urlBase = str_replace(array('&', '"'), array('&amp;', '&quot;'), $urlBase);

		header('Content-Type: text/xml');
		echo '<?xml version="1.0"?><gallery><album lgpath="' . $urlBase . '" tnpath="' . $urlBase . '">';
		for($i = 0; $i < (int)$_GET['count']; $i++) {
			echo '<img src="' . $i . '-full.jpg' . $uriSuffix . '" tn="' . $i . '-medium.jpg' . $uriSuffix . '" link="javascript:dsidx.details.LaunchLargePhoto('. $i .','. $_GET['count'] .',\''. $urlBase .'\',\''. $uriSuffix .'\')" target="_blank" />';
		}
		echo '</album></gallery>';
		exit;
	}
	static function SlideshowParams(){
		$count = @$_GET['count'];
		$uriSuffix = @$_GET['uriSuffix'];
		$uriBase = @$_GET['uriBase'];

		$slideshow_xml_url = admin_url( 'admin-ajax.php' )."?action=dsidx_client_assist&dsidx_action=SlideshowXml&count=$count&uriSuffix=$uriSuffix&uriBase=$uriBase";
		$param_xml = file_get_contents(plugin_dir_path(__FILE__).'assets/slideshowpro-generic-params.xml');
		$param_xml = str_replace("{xmlFilePath}", htmlspecialchars($slideshow_xml_url), $param_xml);
		$param_xml = str_replace("{imageTitle}", "", $param_xml);

		header('Content-Type: text/xml');
		echo($param_xml);
		exit;
	}
	static function EmailFriendForm(){
		$referring_url = $_SERVER['HTTP_REFERER'];
		$post_vars = $_POST;
		$post_vars["referringURL"] = $referring_url;

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("EmailFriendForm", $post_vars, false, 0);

		echo $apiHttpResponse["body"];
		die();
	}
	static function LoginRecovery(){
		global $curent_site, $current_blog, $blog_id;
		
		$referring_url = $_SERVER['HTTP_REFERER'];
		$post_vars = $_POST;
		$post_vars["referringURL"] = $referring_url;
		$post_vars["domain"] = $current_blog->domain;
		$post_vars["path"] = $current_blog->path;
		
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("LoginRecovery", $post_vars, false, 0);
		
		echo $apiHttpResponse["body"];
		die();
	}
	static function ResetPassword(){
		$referring_url = $_SERVER['HTTP_REFERER'];
		$post_vars = $_POST;
		$post_vars["referringURL"] = $referring_url;

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("ResetPassword", $post_vars, false, 0);
		
		echo $apiHttpResponse["body"];
		die();	
	}
	static function ContactForm(){
		$referring_url = @$_SERVER['HTTP_REFERER'];
		$post_vars = $_POST;
		$post_vars["referringURL"] = $referring_url;

		//Fix up post vars for Beast ContactForm API
		if (isset($post_vars['name']) && !isset($post_vars['firstName'])) {
			if(empty($post_vars['name']) || !is_email($post_vars['emailAddress'])){
				header('Content-type: application/json');
				echo '{ "Error": true, "Message": "Failed to submit." }';
				die();
	        }
			$name = $post_vars['name'];
			$name_split = preg_split('/[\s]+/', $post_vars['name'], 2, PREG_SPLIT_NO_EMPTY);
			$post_vars['firstName'] = count($name_split) > 0 ? $name_split[0] : '';
			$post_vars['lastName'] = count($name_split) > 1 ? $name_split[1] : '';
		}
		if (isset($post_vars['firstName']) && !isset($post_vars['name'])) {
			if(empty($post_vars['firstName']) || empty($post_vars['lastName']) || !is_email($post_vars['emailAddress'])){
				header('Content-type: application/json');
				echo '{ "Error": true, "Message": "Failed to submit." }';
				die();
	        }
	    }
		if (!isset($post_vars['phoneNumber'])) $post_vars['phoneNumber'] = '';
		
		$message = (!empty($post_vars['scheduleYesNo']) && $post_vars['scheduleYesNo'] == 'on' ? "Schedule showing on {$post_vars['scheduleDateMonth']} / {$post_vars['scheduleDateDay']} " : "Request info ") . 
						@"for ".(!empty($post_vars['propertyStreetAddress']) ? $post_vars['propertyStreetAddress']:"")." ".(!empty($post_vars['propertyCity']) ? $post_vars['propertyCity'] : "").", ".(!empty($post_vars['propertyState']) ? $post_vars['propertyState'] : "")." ".(!empty($post_vars['propertyZip']) ? $post_vars['propertyZip'] : "").
						@". ".$post_vars['comments'];

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("ContactForm", $post_vars, false, 0);

		if (false && $_POST["returnToReferrer"] == "1") {
			$post_response = json_decode($apiHttpResponse["body"]);

			if ($post_response->Error == 1)
				$redirect_url = $referring_url .'?dsformerror='. $post_response->Message;
			else
				$redirect_url = $referring_url;

			header( 'Location: '. $redirect_url ) ;
			die();
		} else {
			echo $apiHttpResponse["body"];
			die();
		}
		header('Content-type: application/json');
		echo '{ "Error": false, "Message": "" }';
		die();
	}
	static function PrintListing(){
		if($_REQUEST["PropertyID"]) $apiParams["query.PropertyID"] = $_REQUEST["PropertyID"];
		if($_REQUEST["MlsNumber"]) $apiParams["query.MlsNumber"] = $_REQUEST["MlsNumber"];
		$apiParams["responseDirective.ViewNameSuffix"] = "print";
		$apiParams["responseDirective.IncludeDisclaimer"] = "true";
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Details", $apiParams, false);

		header('Cache-control: private');
		header('Pragma: private');
		header('X-Robots-Tag: noindex');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

		echo($apiHttpResponse["body"]);
		die();
	}
	static function OnBoard_GetAccessToken(){
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("OnBoard_GetAccessToken");
		echo $apiHttpResponse["body"];
		die();
	}
	static function Login(){
		$post_vars = $_POST;

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Login", $post_vars, false, 0);

		$response = json_decode($apiHttpResponse["body"]);
		
		if($response->Success){			
			$remember = !empty($_POST["remember"]) && $_POST["remember"] == "on" ? time()+60*60*24*30 : 0;
			
			setcookie('dsidx-visitor-public-id', $response->Visitor->PublicID, $remember, '/');
			setcookie('dsidx-visitor-auth', $response->Visitor->Auth, $remember, '/');
		}

		echo $apiHttpResponse["body"];
		die();
	}
	static function ValidateLogout(){
		// Already logged out
		if ($_COOKIE['dsidx-visitor-auth'] == '')
		{
			header('Content-Type: application/json');
			echo '{ success:false }';
			die();
		}

		$post_vars = $_POST;
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Logout", $post_vars, false, 0);

		header('Content-Type: application/json');
		echo $apiHttpResponse["body"];
		die();
	}
	static function Logout(){
		$post_vars = $_GET;
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Logout", $post_vars, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}
	static function GetVisitor(){
		$post_vars = $_POST;
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("GetVisitor", $post_vars, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}
	static function isOptIn(){
		$post_vars = $_GET;
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("isOptIn", $post_vars, false, 0, null);
		echo $apiHttpResponse["body"];
		die();	
	}
	static function SsoAuthenticated (){
		$post_vars = $_GET;

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("SSOAuthenticated", $post_vars, false, 0, null);
		$response = json_decode($apiHttpResponse["body"]);
		
		if($response->Success){			
			$remember = !empty($_POST["remember"]) && $_POST["remember"] == "on" ? time()+60*60*24*30 : 0;
			
			setcookie('dsidx-visitor-public-id', $response->Visitor->PublicID, $remember, '/');
			setcookie('dsidx-visitor-auth', $response->Visitor->Auth, $remember, '/');
		} else {
			if (isset($_COOKIE['dsidx-visitor-auth']) && $_COOKIE['dsidx-visitor-auth'] != '') {
				// This means the user is no longer logged in globally.
				// So log out of the current session by removing the cookie.
				setcookie('dsidx-visitor-public-id', '', time()-60*60*24*30, '/');
				setcookie('dsidx-visitor-auth', '', time()-60*60*24*30, '/');
			}
		}

		header('Location: ' . $response->Origin);
	}
	static function SsoAuthenticate (){
		$post_vars = $_GET;
		
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("SSO", $post_vars, false, 0, null, true);
	}
	static function SsoSignout (){
		$post_vars = $_GET;

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("SSOSignOut", $post_vars, false, 0, null, true);
	}
	static function Register(){
		foreach($_POST as $key => $value) {
			$post_vars[str_replace('newVisitor_', 'newVisitor.', $key)] = $_POST[$key];
		}
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Register", $post_vars, false, 0);

		$response = json_decode($apiHttpResponse["body"]);
		
		if($response->Success){			
			$remember = @$_POST["remember"] == "on" ? time()+60*60*24*30 : 0;
			
			setcookie('dsidx-visitor-public-id', $response->Visitor->PublicID, $remember, '/');
			setcookie('dsidx-visitor-auth', $response->Visitor->Auth, $remember, '/');
		}

		echo $apiHttpResponse["body"];
		die();
	}
	static function UpdatePersonalInfo(){
		foreach($_POST as $key => $value) {
			$post_vars[str_replace('personalInfo_', 'personalInfo.', $key)] = $_POST[$key];
		}
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("UpdatePersonalInfo", $post_vars, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}
	static function Searches(){				
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Searches", null, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}

	static function UpdateSavedSearchTitle(){
				
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("UpdateSavedSearchTitle", $_POST, false, 0);

		$response = json_decode($apiHttpResponse["body"]);
				
		header('Content-Type: application/json');
		echo $apiHttpResponse["body"];
		die();
	}

	static function ToggleSearchAlert(){
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("ToggleSearchAlert", $_POST, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}
	static function DeleteSearch(){			
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("DeleteSearch", $_POST, false, 0);		
		echo $apiHttpResponse["body"];
		die();
	}
	static function FavoriteStatus(){
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("FavoriteStatus", $_POST, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}
	static function Favorite(){
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Favorite", $_POST, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}
	static function VisitorListings(){
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("VisitorListings", $_POST, false, 0);
		header('Content-Type: text/html');
		echo $apiHttpResponse["body"];
		die();
	}
	static function LoadAreasByType(){
		$_REQUEST['minListingCount'] = 1;
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("LocationsByType", $_REQUEST, false, 0);
		if(!isset($_REQUEST['dataField'])){
			echo $apiHttpResponse["body"];
		}
		else{
			$response = json_decode($apiHttpResponse["body"], true);
			$r = array();
			foreach($response as $item){
				if(isset($item[$_REQUEST['dataField']])){
					$r[] = $item[$_REQUEST['dataField']];
				}
			}
			echo json_encode($r);
		}
		die();
	}
	static function LoadSimilarListings() {
		$apiParams = array();
		$apiParams["query.SimilarToPropertyID"] = $_POST["PropertyID"];
		$apiParams["query.ListingStatuses"] = '1';
		$apiParams['responseDirective.ViewNameSuffix'] = 'Similar';
		$apiParams['responseDirective.IncludeDisclaimer'] = 'true';
		$apiParams['directive.ResultsPerPage'] = '6';

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Results", $apiParams, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}
	static function LoadSoldListings(){
		$apiParams = array();
		$apiParams["query.SimilarToPropertyID"] = $_POST["PropertyID"];
		$apiParams["query.ListingStatuses"] = '8';
		$apiParams['responseDirective.ViewNameSuffix'] = 'Sold';
		$apiParams['directive.ResultsPerPage'] = '6';

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Results", $apiParams, false, 0);
		echo $apiHttpResponse["body"];
		die();
	}
	static function LoadSchools() {
		$apiParams = array();
		$apiParams['responseDirective.ViewNameSuffix'] = 'Schools';
		$apiParams['query.City'] = $_POST['city'];
		$apiParams['query.State'] = $_POST['state'];
		$apiParams['query.Zip'] = $_POST['zip'];
		$apiParams['query.Spatial'] = $_POST['spatial'];
		$apiParams['query.PropertyID'] = $_POST['PropertyID'];

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Schools", $apiParams, false);
		echo $apiHttpResponse["body"];
		die();
	}
	static function LoadDistricts() {
		$apiParams = array();
		$apiParams['responseDirective.ViewNameSuffix'] = 'Districts';
		$apiParams['query.City'] = $_POST['city'];
		$apiParams['query.State'] = $_POST['state'];
		$apiParams['query.Spatial'] = $_POST['spatial'];
		$apiParams['query.PropertyID'] = $_POST['PropertyID'];

		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData("Districts", $apiParams, false);
		echo $apiHttpResponse["body"];
		die();
	}
	static function AutoComplete() {
		$apiParams = array();
		$apiParams['query.partialLocationTerm'] = $_POST['term'];		
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData('AutoCompleteOmniBox', $apiParams, false, 0);
		echo $apiHttpResponse['body'];
		die();
	}
	static function GetPhotosXML() {
		$post_vars = array_map("stripcslashes", $_GET);
		$apiRequestParams = array();
		$apiRequestParams['propertyid'] = $post_vars['pid'];
		$apiHttpResponse = dsSearchAgent_ApiRequest::FetchData('Photos', $apiRequestParams, false);
		echo $apiHttpResponse['body'];
		die();
	}

	//tinymce dialogs for shortcodes
	static function MultiListingsDialog(){
		require_once(DSIDXPRESS_PLUGIN_PATH.'tinymce/multi_listings/dialog.php');
		exit;
	}
	static function SingleListingDialog(){
		require_once(DSIDXPRESS_PLUGIN_PATH.'tinymce/single_listing/dialog.php');
		exit;
	}
	static function LinkBuilderDialog(){
		require_once(DSIDXPRESS_PLUGIN_PATH.'tinymce/link_builder/dialog.php');
		exit;
	}
	static function IdxQuickSearchDialog(){
		require_once(DSIDXPRESS_PLUGIN_PATH.'tinymce/idx_quick_search/dialog.php');
		exit;
	}
}
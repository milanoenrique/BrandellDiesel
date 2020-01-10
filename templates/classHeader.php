<?php

	/**
	* 
	*/
	class classHeader
	{
		
		private $pageTitle;
		private $pageIcon;
		private $pageMenuItems;

		//Set and Get Section

		public function getPageTitle(){
			return $this->pageTitle;
		}

		public function setPageTitle($pageTitle){
			$this->pageTitle = $pageTitle;
		}

		public function getPageIcon(){
			return $this->pageIcon;
		}

		public function setPageIcon($pageIcon){
			$this->pageIcon = $pageIcon;
		}

		public function getPageMenuItems(){
			return $this->pageMenuItems;
		}

		public function setPageMenuItems($pageMenuItems){
			$this->pageMenuItems = $pageMenuItems;
		}


		function __construct($data=null){
			
			$defaultValues=array(
				'pageTitle'		=> 'BDI - Parts request',
				'pageIcon'		=> 'Brandell Diesel Inc.',
				'pageMenuItems'	=> array()

			);

			if ($data==null){ $data=$defaultValues; };

			foreach ($data as $key => $value) {
				$this->$key=$value;
			}

		}

		static function buildMenu($data,$key){

			$_id=	(isset($data['id'])) ?'id="'.$data['id'].'"' : '' ;
			$_icon=	(isset($data['icon'])) ? $data['icon']:'' ;
			$_url=	(isset($data['url'])) ? $data['url']: '#' ;

			ob_start();
				include('components/main_menu.php');
				$return = ob_get_contents();
			ob_end_clean();

			return $return;

		}

		public function setDefaultMenuItems($session,$profile='ADMIN'){

			$argsHeader=array(  
		        'Logout'        =>array(
		            'icon'  =>'fa fa-sign-in',
		            'url'   =>'logout.php?logout=logout'.$session
		        )
		    );

		    if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST') {
		        $auxarray=array(   
		            'New Support Ticket'  =>array(
		                'icon'  =>'fa fa-ticket',
		                'id'    =>'linkToTicketSupport'
		            ) 
		        );

		        $argsHeader=$auxarray+$argsHeader;
			}

		    if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST') {
		        $auxarray=array(   
		            'New Write Up'  =>array(
		                'icon'  =>'fa fa-user-plus',
		                'id'    =>'linkTomyModalWriteUp'
		            ) 
		        );

		        $argsHeader=$auxarray+$argsHeader;
			}
			
			
			if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST') {
		        $auxarray=array(   
		            'New Expenditure'  =>array(
		                'icon'  =>'fa fa-dollar',
		                'id'    =>'linkToAuthorizationExpenditure'
		            ) 
		        );

		        $argsHeader=$auxarray+$argsHeader;
		    }

		    if ($profile != 'TV'){

		    	$auxarray=array(   
		            'New Parts Request'  =>array(
		                'icon'  =>'fa fa-shopping-cart',
		                'class'    =>'linkToMyModalPartsRequesition'
		            ) 
		        );

		    	$argsHeader=$auxarray+$argsHeader;
		    }

		    if ($profile=='ADMIN') {
		        $auxarray=array(   
		            'Admin'         =>array(
		                'group' =>array(
		                    'Users'     =>array(
		                        'id'=>'adminUsers'
		                    ),
		                    'Groups'    =>array(
		                        'id'=>'adminGroups'
		                    )
		                ),
		                'icon'  =>'fa fa-cogs'
		            )

		        );
		        $argsHeader=$auxarray+$argsHeader;
		    }

		    $this->setPageMenuItems($argsHeader);

		}

		public function getHeader($techName,$profile){ require('views/viewHeader.php'); }

	}


?>
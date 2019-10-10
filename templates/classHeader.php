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


		function __construct($data=null)
		{
			
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

		public function buildMenu($data,$key){

			$retorno='';
			$_id=	(isset($data['id'])) ?'id="'.$data['id'].'"' : '' ;
			$_icon=	(isset($data['icon'])) ? $data['icon']:'' ;
			$_url=	(isset($data['url'])) ? $data['url']: '#' ;

			if (isset($data['group'])) {
				$retorno.='<li class="dropdown">';
				$retorno.='<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="'.$_icon.'" aria-hidden="true"></span> '.$key.'<span class="caret"></span></a><ul class="dropdown-menu">';

					foreach ($data['group'] as $groupkey => $groupvalue) {
						$retorno.= $this->buildMenu($groupvalue,$groupkey);
					}

				$retorno.='</ul></li>';

			}else{
				$retorno.='<li><a '.$_id.' href="'.$_url.'"><span class="'.$_icon.'" aria-hidden="true"></span> '.$key.'</a></li>';
			}

			return $retorno;

		}

		public function setDefaultMenuItems($session,$profile='ADMIN'){

			$argsHeader=array(  
		        'Logout'        =>array(
		            'icon'  =>'fa fa-sign-in',
		            'url'   =>'logout.php?logout=logout'.$session
		        )
		    );

			if ($profile!='TV') {

				if ($profile!='ASSIST') {
					
					$auxarray=array(   
			            'New Parts Request'=>array(
				            'icon'  =>'fa fa-cogs',
				            'id'    =>'linkToMyModalPartsRequesition'
				        )
			        );

			        $argsHeader=$auxarray+$argsHeader;
				}

		        $auxarray=array(   
		            'Send Message'  =>array(
			            'icon'  =>'fa fa-phone',
			            'id'    =>'linkToMyModalSendMessage'
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

		public function getHeader(){

			require('views/viewHeader.php');

		}

	}


?>
			var json=vJson;
			var Obj =JSON.parse(json);
			
			var htmlPais = "<option value=''>-- seleccionar --</option>";
								
			for (var i in Obj)
			{
				//alert('hola');
				
				for (var j in Obj[i]) {
					
					if(Obj[i][j]['descripcionlocalidad']!=undefined){	
					//alert('hola');
						//alert(Obj[i][j]['descripcionlocalidad']);
						htmlPais += "<option value=" + Obj[i][j]['idlocalidad']+ ">" + Obj[i][j]['descripcionlocalidad'] + "</option>";
					}
					document.getElementById("pais").innerHTML = htmlPais;
					document.getElementById("pais2").innerHTML = htmlPais;	
				
				}
			}
			
			function changeFunc(vObjName) {
				//alert(vObjName);
				var selectBox = document.getElementById(vObjName);
				var selectedValue = selectBox.options[selectBox.selectedIndex].value;
				//alert(selectedValue);
				cleanFunc(vObjName);
				changeInnerHtml(vObjName, selectedValue);
			}
			
			function cleanFunc(vObjName) {
				if (vObjName=='pais' || vObjName=='pais2') {
					if (vObjName=='pais') {
						mi_select = document.getElementById('estado');
						mi_select.innerHTML="<option value=''>-- seleccionar --</option>";

						mi_select = document.getElementById('ciudad');
						mi_select.innerHTML="<option value=''>-- seleccionar --</option>";
					}
					if (vObjName=='pais2') {
						mi_select = document.getElementById('estado2');
						mi_select.innerHTML="<option value=''>-- seleccionar --</option>";

						mi_select = document.getElementById('ciudad2');
						mi_select.innerHTML="<option value=''>-- seleccionar --</option>";
					}
				}
				if (vObjName=='estado') {
					mi_select = document.getElementById('ciudad');
					mi_select.innerHTML="<option value=''>-- seleccionar --</option>";
				}
				if (vObjName=='estado2') {
					mi_select = document.getElementById('ciudad2');
					mi_select.innerHTML="<option value=''>-- seleccionar --</option>";
				}
			}
			
			function changeInnerHtml(vObjName, selectedValue)
			{				
				var htmlEstado="<option value=''>-- seleccionar --</option>";
				var htmlCiudad="<option value=''>-- seleccionar --</option>";
				
				for (var i in Obj)
				{
					
					for (var j in Obj[i]) {								
						
						for (var z in Obj[i][j]) {
							
							for (var q in Obj[i][j][z]) {
								
								//A este nivel evaluamos los estados, condados y departamentos
								if(Obj[i][j]['idlocalidad']==selectedValue){
									
									//if (vObjName=='pais' || vObjName=='pais2') {
										
										if(Obj[i][j][z][q]['descripcionlocalidad']!=undefined){	
										
											htmlEstado += "<option value=" + Obj[i][j][z][q]['idlocalidad']+ ">" + Obj[i][j][z][q]['descripcionlocalidad'] + "</option>";
										}
										
										if(vObjName=='pais'){
											document.getElementById("estado").innerHTML = htmlEstado;
										}											
										if(vObjName=='pais2'){
											document.getElementById("estado2").innerHTML = htmlEstado;
										}
								  //}	
								}
								
								//A este nivel evaluamos las ciudades de cada estado, condado o departamento
								if(Obj[i][j][z][q]['idlocalidad']==selectedValue){
								
									for (var e in Obj[i][j][z][q]) {
										
										for (var k in Obj[i][j][z][q][e]) {
											
											//if (vObjName=='estado' || vObjName=='estado2') {
											
												if(Obj[i][j][z][q][e][k]['descripcionlocalidad']!=undefined){	
												
													htmlCiudad += "<option value=" + Obj[i][j][z][q][e][k]['idlocalidad']+ ">" + Obj[i][j][z][q][e][k]['descripcionlocalidad'] + "</option>";
												}
												
												if(vObjName=='estado'){
													document.getElementById("ciudad").innerHTML = htmlCiudad;
												}
												if(vObjName=='estado2'){
													document.getElementById("ciudad2").innerHTML = htmlCiudad;
												}
										    //}
										}
									}
								}	
							}
						}
					}
				}				
			}
			//--*/

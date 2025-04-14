$(document).ready(function(){

    $('#busquedaProd').focus();

    $('.btnMenu').click(function(e){
        e.preventDefault();
        if ($('nav').hasClass('viewMenu')) 
        {
            $('nav').removeClass('viewMenu');
        }else{
            $('nav').addClass('viewMenu');
        }
    });

    $('nav ul li').click(function(){
        $('nav ul li ul').slideUp();
        $(this).children('ul').slideToggle();
    });


    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

        if ($("#foto_actual") && $("#foto_remove")){
            $("#foto_remove").val('img_producto.png');
        }

    });

    //Modal for add product//
    $('.add_product').click(function(e) {
        /*Act on the event*/
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Agregar Producto</h1>'+
                                            '<h2 class="nameProducto">'+info.descripcion+'</h2> <br>'+
                                            '<input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del producto" required><br>'+
                                            '<input type="text" name="precio" id="txtPrecio" placeholder="Precio del producto" required>'+
                                            '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                            '<input type="hidden" name="action" value="addProduct" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    });

    //Modal for Delete product//
    $('.del_product').click(function(e) {
        /*Act on the event*/
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); delProduct();">'+
                                            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Eliminar Producto</h1>'+
                                            '<p>¿Está seguro de eliminar el siguiente registro?</p>'+
                                            '<h2 class="nameProducto">'+info.descripcion+'</h2> <br>'+
                                            '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                            '<input type="hidden" name="action" value="delProduct" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>'+             
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    });

    $('#search_proveedor').change(function(e){
        e.preventDefault();
        var sistema = getUrl();
        location.href = sistema+'buscar_productos.php?proveedor='+$(this).val();
    });

    //Activa compo par registrar cliente
    $('.btn_new_cliente').click(function(e){
        e.preventDefault();
        $('#nit_cliente').removeAttr('disabled');
        $('#tel_cliente').removeAttr('disabled');
        $('#dir_cliente').removeAttr('disabled');

        $('#div_registro_cliente').slideDown();
    });

    //Buscar Cliente
    /*$('#nit_cliente').keyup(function(e){
        e.preventDefault();

        var cl = $(this).val();
        var action = 'searchCliente';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,cliente:cl},

            success: function(response)
            {
                if (response == 0) {
                    $('#idcliente').val('');
                    $('#nom_cliente').val('');
                    $('#tel_cliente').val('');
                    $('#dir_cliente').val('');
                    //Mostrar boton agregar
                    $('.btn_new_cliente').slideDown();
                }else{
                    var data = $.parseJSON(response);
                    $('#idcliente').val(data.idcliente);
                    $('#nom_cliente').val(data.nombre);
                    $('#tel_cliente').val(data.telefono);
                    $('#dir_cliente').val(data.direccion);
                    //Quitar boton agregar
                    $('.btn_new_cliente').slideUp();

                    //Bloque campos
                    $('#nom_cliente').attr('disabled','disabled');
                    $('#tel_cliente').attr('disabled','disabled');
                    $('#dir_cliente').attr('disabled','disabled');

                    //Ocultar boton guardar
                    $('#div_registro_cliente').slideUp();
                }
            },
            error: function(error){
            }
        });
    });*/

     //Buscar Cliente
    $('#nom_cliente').keyup(function(e){
        e.preventDefault();

        var cl = $(this).val();
        var action = 'searchCliente';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,cliente:cl},

            success: function(response)
            {
                if (response == 0) {
                    $('#idcliente').val('');
                    $('#nit_cliente').val('');
                    $('#tel_cliente').val('');
                    $('#dir_cliente').val('');
                    //Mostrar boton agregar
                    $('.btn_new_cliente').slideDown();
                }else{
                    var data = $.parseJSON(response);
                    $('#idcliente').val(data.idcliente);
                    $('#nit_cliente').val(data.nit);
                    $('#tel_cliente').val(data.telefono);
                    $('#dir_cliente').val(data.direccion);
                    //Quitar boton agregar
                    $('.btn_new_cliente').slideUp();

                    //Bloque campos
                    $('#nit_cliente').attr('disabled','disabled');
                    $('#tel_cliente').attr('disabled','disabled');
                    $('#dir_cliente').attr('disabled','disabled');

                    //Ocultar boton guardar
                    $('#div_registro_cliente').slideUp();
                }
            },
            error: function(error){
            }
        });
    });

    //Crear cliente - Ventas
    $('#form_new_cliente_venta').submit(function(e){
        e.preventDefault();

        if ($('#nit_cliente').attr('disabled')) {
            return false;
        }

        if ($('#tel_cliente').attr('disabled')) {
            return false;
        }
        
        if ($('#dir_cliente').attr('disabled')) {
            return false;
        }

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: $('#form_new_cliente_venta').serialize(),

            success: function(response)
            {
                if (response != 'error') {
                    //Agregar id al input hidden
                    $('#idcliente').val(response);
                    //Bloque campos
                    $('#nit_cliente').attr('disabled','disabled');
                    $('#tel_cliente').attr('disabled','disabled');
                    $('#dir_cliente').attr('disabled','disabled');

                    //Ocultar boton gagregar
                    $('.btn_new_cliente').slideUp();
                    //Ocultar boton guardar
                    $('#div_registro_cliente').slideUp();
                }
            },
            error: function(error){
            }
        });
    });

    //Buscar Producto
    $('#txt_cod_producto').keyup(function(e){
        e.preventDefault();

        var producto = $(this).val();
        var action = 'infoProducto';
    if (producto != '') 
    {   
        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,producto:producto},

            success: function(response)
            {
                //console.log(response);
                if (response != 'error')
                 {
                    var info = JSON.parse(response);
                    $('#txt_id_producto').val(info.codproducto);
                    $('#txt_descripcion').html(info.descripcion);
                    $('#txt_existencia').html(info.existencia);
                    $('#txt_cant_producto').val('1');
                    $('#txt_precio').val(info.precio);
                    $('#txt_precio_total').html(info.precio);

                    //Activar cantidad
                    $('#txt_cant_producto').removeAttr('disabled');
                    $('#txt_precio').removeAttr('disabled');
                    $('#txt_id_producto').removeAttr('disabled');

                    //Mostrar boton agregar
                    $('#add_product_venta').slideDown();
                 }else{
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').val('0');
                    $('#txt_precio').val('0.00');
                    $('#txt_precio_total').html('0.00');

                    //Bloquear cantidad
                    $('#txt_cant_producto').attr('disabled','disabled');

                    //Ocultar boton agregar
                    $('#add_product_venta').slideUp();

                 }
            },
            error: function(error){
            }
        });
     }   
    });

    //Buscar Producto Compras
    $('#txt_cod_producto_compra').focus();
    $('#txt_cod_producto_compra').keyup(function(e){
        e.preventDefault();

        var producto = $(this).val();
        var action = 'infoProducto';
    if (producto != '') 
    {   
        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,producto:producto},

            success: function(response)
            {
                //console.log(response);
                if (response != 'error')
                 {
                    var info = JSON.parse(response);
                    $('#txt_id_producto_compra').val(info.codproducto);
                    $('#txt_descripcion_compra').html(info.descripcion);
                    $('#txt_existencia_compra').html(info.existencia);
                    $('#txt_cant_producto_compra').val('1');
                    $('#txt_precio_compra').val(info.costo);
                    $('#txt_precio_total_compra').html(info.costo);

                    //Activar cantidad
                    $('#txt_cant_producto_compra').removeAttr('disabled');
                    $('#txt_precio_compra').removeAttr('disabled');
                    $('#txt_id_producto_compra').removeAttr('disabled');

                    //Mostrar boton agregar
                    $('#add_product_venta').slideDown();
                 }else{
                    $('#txt_descripcion_compra').html('-');
                    $('#txt_existencia_compra').html('-');
                    $('#txt_cant_producto_compra').val('0');
                    $('#txt_precio_compra').html('0.00');
                    $('#txt_precio_total_compra').html('0.00');

                    //Bloquear cantidad
                    $('#txt_cant_producto_compra').attr('disabled','disabled');

                    //Ocultar boton agregar
                    $('#add_product_venta').slideUp();

                 }
            },
            error: function(error){
            }
        });
     }   
    });

    //Validar cantidad del producto antes de agregar
    $('#txt_cant_producto').keyup(function(e){
        e.preventDefault();
        var precio_total = $(this).val() * $('#txt_precio').val();
        var existencia = parseInt($('#txt_existencia').html());
        $('#txt_precio_total').html(precio_total);

        //Ocultar el boton agregar si la cantidad es menor a 1
        if (($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia)){
            $('#add_product_venta').slideUp();
        }else{
            $('#add_product_venta').slideDown();
        }
    });

    //Validar cantidad del producto antes de agregar
    $('#txt_cant_producto_compra').keyup(function(e){ 
        e.preventDefault();
        console.log($(this).val());
        var precio_total = $(this).val() * $('#txt_precio_compra').val();
        var existencia = parseInt($('#txt_existencia_compra').html());
        $('#txt_precio_total_compra').html(precio_total);

    });

    //Cambiar Password
    $('.newPass').keyup(function(){
        validPass();
    });

    //Form cambiar contraseña
    $('#frmChangePass').submit(function(e){
        e.preventDefault();

        var passActual = $('#txtPassUser').val();
        var passNuevo = $('#txtNewPassUser').val();
        var confirmPassNuevo = $('#txtPassConfirm').val();
        var action = "changePassword";

        if (passNuevo != confirmPassNuevo) {
        $('.alertChangePass').html('<p style="color:red;">Las contraseñas no son iguales.</p>');
        $('.alertChangePass').slideDown();
        return false;
    }

    if (passNuevo.length < 4) {
        $('.alertChangePass').html('<p style="color:red;">La contraseña debe ser de 4 caracteres como mínimo.</p>');
        $('.alertChangePass').slideDown();
        return false;
    }
    $.ajax({
                url : 'ajax.php',
                type: "POST",
                async : true,
                data: {action:action,passActual:passActual,passNuevo:passNuevo},

                success: function(response)
                {

                    if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        if (info.cod == '00') {
                            $('.alertChangePass').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#frmChangePass')[0].reset();
                        }else{
                             $('.alertChangePass').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                          $('.alertChangePass').slideDown();
                    }
                },
                error: function(error){
                }
            });

    });

    //Actualizar datos de la empresa
    $('#frmEmpresa').submit(function(e){
        e.preventDefault();

        var intNit          = $('#txtNit').val();
        var strNombreEmp    = $('#txtNombre').val();
        var strRsocialEmp   = $('#txtRSocial').val();
        var intTelEmp       = $('#txtTelEmpresa').val();
        var strEmailEmp     = $('#txtEmailEmpresa').val();
        var strDirEmp       = $('#txtDirEmpresa').val();
        var intMoneda       = $('#txtMoneda').val();
        var intIva          = $('#txtIva').val();
        var parametros = new FormData($('#frmEmpresa')[0]);

        if (intNit == '' || strNombreEmp == '' || intTelEmp == '' || strEmailEmp == '' || strDirEmp == '') {
            $('.alertFormEmpresa').html('<p style="color:red;">Todos los campos son obligatorio.</p>');
            $('.alertFormEmpresa').slideDown();
            return false;
        }

        $.ajax({
                url : 'ajax.php',
                type: "POST",
                async : true,
                data: parametros,
                contentType: false,
                processData: false,


                beforeSend: function(){
                    $('.alertFormEmpresa').slideUp();
                    $('.alertFormEmpresa').html('');
                    $('#frmEmpresa input').attr('disabled', 'disabled');

                },

                success: function(response)
                {

                        console.log(response);
                        var info = JSON.parse(response);
                        if (info.cod == '00') {
                            $('.alertFormEmpresa').html('<p style="color: #23922d;">'+info.msg+'</p>');                          
                            $('.alertFormEmpresa').slideDown();
                        }else{
                            $('.alertFormEmpresa').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        $('.alertFormEmpresa').slideDown();
                        $('#frmEmpresa input').removeAttr('disabled');
                   
                },
                error: function(error){
                }
            });
    });

    //Agregar cliente desde ventas
    $('.buscarCliente').click(function(e){
        e.preventDefault();
        serchForDetalleCli(); 
        $('.modalBuscarCl').fadeIn();


    });
   
    $('#busquedaCli').focus();
    $('#busquedaCli').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            serchForDetalleCli(1,valorBusqueda);
        }else{
            serchForDetalleCli(1,'');
        }
        
        
    }); 
   
   serchForDetalleProd('',1);
    //$('#busquedaProd').focus();
    $('#busquedaProd').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            serchForDetalleProd(valorBusqueda,1);
        }else{
            serchForDetalleProd('',1);
        }
                
    });

     $("body").on("click","#paginadorProd li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaProd]").val();
        //console.log(valorhref);
        serchForDetalleProd(valorBuscar,valorhref);
    });

     $('#busquedaProdNombre').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            serchForDetalleProd(valorBusqueda,1);
        }else{
            serchForDetalleProd('',1);
        }
                
    });

     $("body").on("click","#paginadorProd li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaProdNombre]").val();
        //console.log(valorhref);
        serchForDetalleProd(valorBuscar,valorhref);
    });

     serchForDetalleProdCompra('',1);
    $('#busquedaProdCompra').focus();
    $('#busquedaProdCompra').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            serchForDetalleProdCompra(valorBusqueda,1);
        }else{
            serchForDetalleProdCompra('',1);
        }
                
    });

     $("body").on("click","#paginadorProdCompra li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaProdCompra]").val();
        //console.log(valorhref);
        serchForDetalleProdCompra(valorBuscar,valorhref);
    });

    //Lista cliente
    listaCliente('',1,10);

    $('#busquedaCliente').focus();
    $('#busquedaCliente').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_clientes").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            listaCliente(valorBusqueda,1,valoroption);
        }else{
            listaCliente('',1,10);
        }              
    });

     $("body").on("click","#paginadorClient li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaCliente]").val();
        valoroption = $("#cantidad_mostrar_clientes").val();
        //console.log(valorhref);
        listaCliente(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_clientes").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaCliente]").val();
        //console.log(valorBuscar);
        listaCliente(valorBuscar,1,valoroption);
    });

        //Lista gastos
    listaCajas('',1,10);

    $("#busquedaCaja").change(function(){
        valorBuscar = $(this).val();
        //console.log(valoroption);
        valoroption = $("#cantidad_mostrar_caja").val();
        //console.log(valorBuscar);
        listaCajas(valorBuscar,1,valoroption);
    });
     $("body").on("click","#paginadoCaja li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaCaja]").val();
        valoroption = $("#cantidad_mostrar_caja").val();
        //console.log(valorhref);
        listaCajas(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_caja").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaCaja]").val();
        //console.log(valorBuscar);
        listaCajas(valorBuscar,1,valoroption);
    });


     //Lista gastos
    listaGastos('',1,10);

    $('#busquedaEgresos').focus();
    $('#busquedaEgresos').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_egresos").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            listaGastos(valorBusqueda,1,valoroption);
        }else{
            listaGastos('',1,valoroption);
        }    
    });

    $("body").on("click","#paginadoEgresos li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaEgresos]").val();
        valoroption = $("#cantidad_mostrar_egresos").val();
        //console.log(valorhref);
        listaGastos(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_egresos").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaEgresos]").val();
        //console.log(valorBuscar);
        listaGastos(valorBuscar,1,valoroption);
    });

    $('#nuevoCliente').click(function(e){
        e.preventDefault();

        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); nuevoCliente();">'+                                           
                                            '<h1><i class="fas fa-user-plus" style="font-size: 45pt;"></i> <br> Registrar cliente</h1>'+
                                            '<input type="hidden" name="action" value="nuevoCliente" required><br>'+
                                            '<input type="text" name="nitCliente" id="nitCliente" value="" placeholder="Nit" required><br>'+
                                            '<input type="text" name="nombreCliente" id="nombreCliente" value="" placeholder="Nombre y apellidos" onkeypress="return soloLetras(event)" onpaste="return false" required><br>'+
                                            '<input type="number" name="telefonoCliente" id="telefonoCliente" value="" placeholder="Teléfono" required><br>'+
                                            '<input type="text" name="direccionCliente" id="direccionCliente" value="" placeholder="Dirección" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
        $('.modal').fadeIn();

    });

    $('#nuevoEgreso').click(function(e){
        e.preventDefault();

        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); nuevoEgreso();">'+                                           
                                            '<h1><i class="fa fa-file-alt fa-w-12" style="font-size: 45pt;"></i> <br> Registrar Egreso</h1>'+
                                            '<input type="hidden" name="action" value="nuevoEgreso" required><br>'+
                                            '<input type="text" name="descEgreso" id="descEgreso" value="" placeholder="Descripción" required><br>'+
                                            '<input type="number" name="cantEgreso" id="cantEgreso" value="" placeholder="Cantidad" step="any" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
        $('.modal').fadeIn();

    });

    //abrir caja
      $('#abrir_caja').click(function(e){
        e.preventDefault();

        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); event.stopImmediatePropagation(); nuevaCaja();">'+                                           
                                            '<h1><i class="fa fa-money-bill-alt fa-w-20" style="font-size: 45pt;"></i> <br> Abrir caja</h1>'+
                                            '<input type="hidden" name="action" value="nuevaCaja" required><br>'+
                                            '<label>Cantidad:</label>'+
                                            '<input class="textcenter" type="number" name="inicioCaja" id="inicioCaja" value="" placeholder="C$ 0.00" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
        $('.modal').fadeIn();

    });

//Devolucion
    $('#devolucion').click(function(e){
        e.preventDefault();

        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); devolucion();">'+                                           
                                            '<h1><i class="fas fa-cube" style="font-size: 45pt;"></i> <br> Devolución</h1>'+
                                            '<input type="hidden" name="action" value="devolucion" required>'+
                                            '<label>No. Venta</label>'+
                                            '<input style="text-align:center;" type="text" name="noVenta_dev" id="noVenta_dev" value="" placeholder="No. venta" required>'+
                                            '<label>Producto</label>'+
                                            '<input style="text-align:center;" type="text" name="codProducto_dev" id="codProducto_dev" value="" placeholder="Código del producto" required>'+
                                            '<label>Cantidad</label>'+
                                            '<input style="text-align:center;" type="number" name="cantProducto_dev" id="cantProducto_dev" value="1" placeholder="" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
        $('.modal').fadeIn();

    });

    //Lista Usuarios
    listaUsuario('',1,10);

    $('#busquedaUsuario').focus();
    $('#busquedaUsuario').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_usuarios").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            listaUsuario(valorBusqueda,1,valoroption);
        }else{
            listaUsuario('',1,valoroption);
        }     
    });

     $("body").on("click","#paginadorUsuario li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaUsuario]").val();
        valoroption = $("#cantidad_mostrar_usuarios").val();
        //console.log(valorhref);
        listaUsuario(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_usuarios").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaUsuario]").val();
        //console.log(valorBuscar);
        listaUsuario(valorBuscar,1,valoroption);
    });

    $('#nuevoUsuario').click(function(e){
        e.preventDefault();
        var action= 'selecionarRol';
       $.ajax({
                url : 'ajax.php',
                type : "POST",
                data : {action:action},

                success: function(response)
                {
                        //console.log(response);
                        var info = JSON.parse(response);

        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); nuevoUsuario();">'+                                           
                                            '<h1><i class="fas fa-user-plus" style="font-size: 45pt;"></i> <br> Registrar usuario</h1>'+
                                            '<input type="hidden" name="action" value="nuevoUsuario" required><br>'+
                                            '<input type="text" name="nombreUsuario" id="nombreUsuario" value="" placeholder="Nombre completo" onkeypress="return soloLetras(event)" onpaste="return false" required><br>'+
                                            '<input type="email" name="correoUsuario" id="correoUsuario" value="" placeholder="Correo" required><br>'+
                                            '<input type="text" name="usuario" id="usuario" value="" placeholder="Usuarios" required><br>'+
                                            '<input type="password" name="claveUsuario" id="claveUsuario" value="" placeholder="Clave" required><br>'+
                                            '<select name="rolUsuario" id="rolUsuario" required>'+info.rol+'</select><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                },
                error: function(error){
                console.log(error);
                }
            });
        $('.modal').fadeIn();

    });

    //Modal estado de resultado
    $('#estado_resultado').click(function(e){
        e.preventDefault();
        var action= 'selecionarRol';
       $.ajax({
                url : 'ajax.php',
                type : "POST",
                data : {action:action},

                success: function(response)
                {
                        //console.log(response);
                        var info = JSON.parse(response);

        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); generarEstado();">'+                                           
                                            '<h1><i class="far fa-file-alt" style="font-size: 45pt;"></i> <br> Generar Estado de Resultado</h1>'+
                                            '<input type="hidden" name="action" value="estadoResultado" required>'+
                                            '<label style="text-align:left !important;">Desde el:</label>'+
                                            '<input type="date" name="desde" id="desde" value="" required><br>'+
                                            '<label style="text-align:left !important;">Hasta el:</label>'+
                                            '<input type="date" name="hasta" id="hasta" value="" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="far fa-file-alt"></i> Generar</button>'+              
                                        '</form>');
                },
                error: function(error){
                console.log(error);
                }
            });
        $('.modal').fadeIn();

    });

    //Lista proveedor
    listaProveedor('',1,10);

     $('#busquedaProveedor').focus();
    $('#busquedaProveedor').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_proveedor").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            listaProveedor(valorBusqueda,1,valoroption);
        }else{
            listaProveedor('',1,valoroption);
        }    
    });

    $("body").on("click","#paginadorProveedor li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaProveedor]").val();
        valoroption = $("#cantidad_mostrar_proveedor").val();
        //console.log(valorhref);
        listaProveedor(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_proveedor").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaProveedor]").val();
        //console.log(valorBuscar);
        listaProveedor(valorBuscar,1,valoroption);
    });

    $('#nuevoProveedor').click(function(e){
        e.preventDefault();

        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); nuevoProveedor();">'+                                           
                                            '<h1><i class="far fa-building " style="font-size: 45pt;"></i> <br> Registrar proveedor</h1>'+
                                            '<input type="hidden" name="action" value="nuevoProveedor" required><br>'+
                                            '<input type="text" name="nombreProveedor" id="nombreProveedor" value="" placeholder="Nombre del proveedor" onkeypress="return soloLetras(event)" onpaste="return false" required><br>'+
                                            '<input type="text" name="nombreContacto" id="nombreContacto" value="" placeholder="Nombre del contacto" onkeypress="return soloLetras(event)" onpaste="return false" required><br>'+
                                            '<input type="number" name="telefonoProveedor" id="telefonoProveedor" value="" placeholder="Teléfono" required><br>'+
                                            '<input type="text" name="direccionProveedor" id="direccionProveedor" value="" placeholder="Dirección" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
        $('.modal').fadeIn();

    })

    //Lista productos
    listaProductos('',1,10);

    $('#busquedaProducto').focus();
    $('#busquedaProducto').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_producto").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            listaProductos(valorBusqueda,1,valoroption);
        }else{
            listaProductos('',1,valoroption);
        }
               
    });

     $("body").on("click","#paginadorProducto li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaProducto]").val();
        valoroption = $("#cantidad_mostrar_producto").val();
        //console.log(valorhref);
        listaProductos(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_producto").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaProducto]").val();
        //console.log(valorBuscar);
        listaProductos(valorBuscar,1,valoroption);
    });

    $('#nuevoProducto').click(function(e){
        e.preventDefault();
        var action= 'selecionarProveedor';
       $.ajax({
                url : 'ajax.php',
                type : "POST",
                data : {action:action},

                success: function(response)
                {
                        console.log(response);
                        var info = JSON.parse(response);

                        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); nuevoProducto();">'+                                           
                                            '<h1><i class="fa fa-cube " style="font-size: 45pt;"></i> <br> Registrar producto</h1>'+
                                            '<input type="hidden" name="action" value="nuevoProducto" required><br>'+
                                            '<select name="nombreProv" id="nombreProv" class="notItemOne">'+info.proveedor+'</select><br>'+
                                            '<input type="text" name="codigoProd" id="codigoProd" value="" placeholder="Código del producto" required><br>'+
                                            '<input type="text" name="nombreProd" id="nombreProd" value="" placeholder="Nombre del producto" required><br>'+
                                            '<input type="number" name="costoProd" id="costoProd" value="" placeholder="Costo del producto" step="any" required><br>'+
                                            '<input type="number" name="precioProd" id="precioProd" value="" placeholder="Precio del producto" step="any" required><br>'+
                                            '<input type="file" name="fotoProd" id="fotoProd" value="" placeholder="Foto del producto" ><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                        
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();

    });

    //Reporte por producto
   $('#reporteProducto').click(function(e){
        e.preventDefault();
        var action= 'selecionarProveedor';
       $.ajax({
                url : 'ajax.php',
                type : "POST",
                data : {action:action},

                success: function(response)
                {
                        //console.log(response);
                        var info = JSON.parse(response);

                        $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); reporteProducto();">'+                                           
                                            '<h1><i class="fa fa-cube " style="font-size: 45pt;"></i> <br> Reporte por producto</h1><br>'+
                                             '<input type="text" name="codigoRepProd" id="codigoRepProd" placeholder="Codigo del producto" required>'+
                                            '<label class="textleft">Desde:</label>'+
                                            '<input type="date" name="inicioReporteProd" id="inicioReporteProd" required>'+
                                            '<label class="textleft">Hasta:</label>'+
                                            '<input type="date" name="finReporteProd" id="finReporteProd" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fa fa-file-alt fa-w-12"></i> Generar</button>'+              
                                        '</form>');
                        
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();

    });

    //Lista ventas
    listaVentas('',1,10);

    $('#busquedaVentas').focus();
    $('#busquedaVentas').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_ventas").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            listaVentas(valorBusqueda,1,valoroption);
        }else{
            listaVentas('',1,valoroption);
        }       
    });

    $("body").on("click","#paginadorVentas li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaVentas]").val();
        valoroption = $("#cantidad_mostrar_ventas").val();
        //console.log(valorhref);
        listaVentas(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_ventas").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaVentas]").val();
        //console.log(valorBuscar);
        listaVentas(valorBuscar,1,valoroption);
    });

       listaCompras('',1,10);

    $('#busquedaCompra').focus();
    $('#busquedaCompra').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_compras").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            listaCompras(valorBusqueda,1,valoroption);
        }else{
            listaCompras('',1,valoroption);
        }       
    });

    $("body").on("click","#paginadorCompras li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaCompra]").val();
        valoroption = $("#cantidad_mostrar_compras").val();
        //console.log(valorhref);
        listaCompras(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_compras").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaCompra]").val();
        //console.log(valorBuscar);
        listaCompras(valorBuscar,1,valoroption);
    });

     //Lista ventas de credito
    listaCreditos('',1);

    $('#busquedaCredito').focus();
    $('#busquedaCredito').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_porcobrar").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            listaCreditos(valorBusqueda,1,valoroption);
        }else{
            listaCreditos('',1,valoroption);
        }       
    });

     $("body").on("click","#paginador_por_cobrar li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaCredito]").val();
        valoroption = $("#cantidad_mostrar_porcobrar").val();
        //console.log(valorhref);
        listaCreditos(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_porcobrar").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaCredito]").val();
        //console.log(valorBuscar);
        listaCreditos(valorBuscar,1,valoroption);
    });

//Busqueda por rango de fecha ventas
    $('.btn_rango_fecha').click(function(e){
        e.preventDefault();
        var desde = $('#fecha_de').val();
        var hasta = $('#fecha_a').val();
        var busqueda = $('#busquedaVentas').val();
        var valoroption = $("#cantidad_mostrar_ventas").val();
        if (desde == '' || hasta == ''){
            return false;
        }

        $.ajax({
            url: 'action/data_ventas.php',
            type: "POST",
            async: true,
            data: {fecha_de:desde,fecha_a:hasta,busqueda:busqueda,cantidad:valoroption},

            success: function(response){
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaVentas').html(info.detalle);
                        $('#paginadorVentas').html(info.totales);

                     }else{
                        $('#listaVentas').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Cliente</th>'+
                                                        '<th>Vendedor</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th class="textright">Total Factura</th>'+
                                                        '<th class="textright">Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorVentas').html('');
                        //console.log('no data');

                     }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    //Busqueda por rango de fecha cuentas por cobrar
    $('.btn_rango_fecha_mov').click(function(e){
        e.preventDefault();
        var desde = $('#fecha_de_mov').val();
        var hasta = $('#fecha_a_mov').val();
        var busqueda = $('#busquedaMov').val();
        var valoroption = $("#cantidad_mostrar_movcobrar").val();
        if (desde == '' || hasta == ''){
            return false;
        }

        $.ajax({
            url: 'action/data_movimientos.php',
            type: "POST",
            async: true,
            data: {fecha_de:desde,fecha_a:hasta,busqueda:busqueda,cantidad:valoroption},

            success: function(response){
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaMovimientos').html(info.detalle);
                        $('#paginadorMovimientos').html(info.totales);

                     }else{
                        $('#listaMovimientos').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Cliente</th>'+
                                                        '<th>Vendedor</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th class="textright">Factura</th>'+
                                                        '<th class="textright">Abono</th>'+
                                                        '<th class="textright">Saldo total</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="8">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorMovimientos').html('');
                        //console.log('no data');

                     }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    //Busqueda por rango de fecha cuentas por pagar
    $('.btn_rango_fecha_mov_pagar').click(function(e){
        e.preventDefault();
        var desde = $('#fecha_de_mov_pagar').val();
        var hasta = $('#fecha_a_mov_pagar').val();
        var busqueda = $('#busquedaMov_proveedor').val();
        var valoroption = $("#cantidad_mostrar_movpagar").val();
        if (desde == '' || hasta == ''){
            return false;
        }

        $.ajax({
            url: 'action/data_mov_proveedor.php',
            type: "POST",
            async: true,
            data: {fecha_de:desde,fecha_a:hasta,busqueda:busqueda,cantidad:valoroption},

            success: function(response){
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaMov_proveedor').html(info.detalle);
                        $('#paginadorMov_proveedor').html(info.totales);

                     }else{
                        $('#listaMov_proveedor').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Cliente</th>'+
                                                        '<th>Vendedor</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th class="textright">Factura</th>'+
                                                        '<th class="textright">Abono</th>'+
                                                        '<th class="textright">Saldo total</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="8">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorMov_proveedor').html('');
                        //console.log('no data');

                     }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    //Busqueda por rango de fecha compras
    $('.btn_rango_fecha_compra').click(function(e){
        e.preventDefault();
        var desde = $('#fecha_de_compra').val();
        var hasta = $('#fecha_a_compra').val();
        var busqueda = $('#busquedaCompra').val();
        var valoroption = $("#cantidad_mostrar_compras").val();
        if (desde == '' || hasta == ''){
            return false;
        }

        $.ajax({
            url: 'action/data_compras.php',
            type: "POST",
            async: true,
            data: {fecha_de:desde,fecha_a:hasta,busqueda:busqueda,cantidad:valoroption},

            success: function(response){
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaCompras').html(info.detalle);
                        $('#paginadorCompras').html(info.totales);

                     }else{
                        $('#listaCompras').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Proveedor</th>'+
                                                        '<th>Usuario</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th class="textright">Total Factura</th>'+
                                                        '<th class="textright">Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorCompras').html('');
                        //console.log('no data');

                     }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    $('#reporte_pdf').click(function(e){
        e.preventDefault();
        var rows = $('#listaVentas tr').length;
        if (rows > 0) 
        {
            var pagina = '';
            var busqueda = $('#busquedaVentas').val();
            var fecha_de = $('#fecha_de').val();
            var fecha_a = $('#fecha_a').val();

            if (fecha_de != '' || fecha_a != '') {
                generarReportePDF_rango(fecha_de,fecha_a,busqueda);
            }else{
                generarReportePDF(pagina,busqueda);
            }
 
            location.reload();
        }
    });

    $('#reporte_pdf_mov').click(function(e){
        e.preventDefault();
        var rows = $('#listaMovimientos tr').length;
        if (rows > 0) 
        {
            var pagina = '';
            var busqueda = $('#busquedaMov').val();
            var fecha_de = $('#fecha_de_mov').val();
            var fecha_a = $('#fecha_a_mov').val();

            if (fecha_de != '' || fecha_a != '') {
                generarReportePDF_rango_mov(fecha_de,fecha_a,busqueda);
            }else{
                generarReportePDF_mov(pagina,busqueda);
            }
 
            location.reload();
        }
    });

    $('#reporte_pdf_mov_pagar').click(function(e){
        e.preventDefault();
        var rows = $('#listaMov_proveedor tr').length;
        if (rows > 0) 
        {
            var pagina = '';
            var busqueda = $('#busquedaMov_proveedor').val();
            var fecha_de = $('#fecha_de_mov_pagar').val();
            var fecha_a = $('#fecha_a_mov_pagar').val();

            if (fecha_de != '' || fecha_a != '') {
                generarReportePDF_rango_mov_pagar(fecha_de,fecha_a,busqueda);
            }else{
                generarReportePDF_mov_pagar(pagina,busqueda);
            }
 
            location.reload();
        }
    });

    $('#reporte_pdf_compra').click(function(e){
        e.preventDefault();
        var rows = $('#listaCompras tr').length;
        if (rows > 0) 
        {
            var pagina = '';
            var busqueda = $('#busquedaCompra').val();
            var fecha_de = $('#fecha_de_compra').val();
            var fecha_a = $('#fecha_a_compra').val();

            if (fecha_de != '' || fecha_a != '') {
                generarReportePDF_rango_compra(fecha_de,fecha_a,busqueda);
            }else{
                generarReportePDF_compra(pagina,busqueda);
            }
 
            location.reload();
        }
    });

    lista_cuentas_por_pagar('',1);
     $('#busquedaPago').focus();
    $('#busquedaPago').keyup(function(e){
        e.preventDefault();

        var valorBusqueda = $(this).val();
        var valoroption = $("#cantidad_mostrar_porpagar").val();
        //console.log(valorBusqueda);

        if (valorBusqueda != "") 
        {
            lista_cuentas_por_pagar(valorBusqueda,1,valoroption);
        }else{
            lista_cuentas_por_pagar('',1,valoroption);
        }       
    });

    $("body").on("click","#paginador_por_pagar li a",function(e){
        e.preventDefault();
        valorhref = $(this).attr("href");
        valorBuscar = $("input[name=busquedaPago]").val();
        valoroption = $("#cantidad_mostrar_porpagar").val();
        //console.log(valorhref);
        lista_cuentas_por_pagar(valorBuscar,valorhref,valoroption);
    });

    $("#cantidad_mostrar_porpagar").change(function(){
        valoroption = $(this).val();
        //console.log(valoroption);
        valorBuscar = $("input[name=busquedaPago]").val();
        //console.log(valorBuscar);
        lista_cuentas_por_pagar(valorBuscar,1,valoroption);
    });

    //Buscar Proveedor
    $('#nom_proveedor').keyup(function(e){
        e.preventDefault();

        var proveedor = $(this).val();
        var action = 'searchProveedor';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,proveedor:proveedor},

            success: function(response)
            {
                //console.log(response);
                if (response == 0) {
                    $('#idproveedor').val('');
                    $('#con_proveedor').val('');
                    $('#tel_proveedor').val('');
                    $('#dir_proveedor').val('');
                    //Mostrar boton agregar
                    $('.btn_new_proveedor').slideDown();
                }else{
                    var data = $.parseJSON(response);
                    $('#idproveedor').val(data.codproveedor);
                    $('#con_proveedor').val(data.contacto);
                    $('#tel_proveedor').val(data.telefono);
                    $('#dir_proveedor').val(data.direccion);
                    //Quitar boton agregar
                    $('.btn_new_proveedor').slideUp();

                    //Bloque campos
                    $('#con_proveedor').attr('disabled','disabled');
                    $('#tel_proveedor').attr('disabled','disabled');
                    $('#dir_proveedor').attr('disabled','disabled');

                    //Ocultar boton guardar
                    $('#div_registro_proveedor').slideUp();
                }
            },
            error: function(error){
            }
        });
    });

        //Activa compo par registrar proveedor
    $('.btn_new_proveedor').click(function(e){
        e.preventDefault();
        $('#con_proveedor').removeAttr('disabled');
        $('#tel_proveedor').removeAttr('disabled');
        $('#dir_proveedor').removeAttr('disabled');

        $('#div_registro_cliente').slideDown();
    });

    //Crear proveedor - compras
    $('#form_new_proveedor_compra').submit(function(e){
        e.preventDefault();

        if ($('#con_proveedor').attr('disabled')) {
            return false;
        }

        if ($('#tel_proveedor').attr('disabled')) {
            return false;
        }
        
        if ($('#dir_proveedor').attr('disabled')) {
            return false;
        }
        


        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: $('#form_new_proveedor_compra').serialize(),

            success: function(response)
            {
                if (response != 'error') {
                    //Agregar id al input hidden
                    $('#idproveedor').val(response);
                    //Bloque campos
                    $('#con_proveedor').attr('disabled','disabled');
                    $('#tel_proveedor').attr('disabled','disabled');
                    $('#dir_proveedor').attr('disabled','disabled');

                    //Ocultar boton gagregar
                    $('.btn_new_cliente').slideUp();
                    //Ocultar boton guardar
                    $('#div_registro_cliente').slideUp();
                }
            },
            error: function(error){
            }
        });
    });

}); //End ready

function generarReporteProducto(desde,hasta,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generarReporteProducto.php?fecha_de='+desde+'&fecha_a='+hasta+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF_rango_compra(desde,hasta,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaReporteRango_compra.php?fecha_de='+desde+'&fecha_a='+hasta+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF_compra(pagina,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaReporte_compra.php?pagina='+pagina+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF_mov(pagina,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generarReportePDF_mov.php?pagina='+pagina+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF_rango_mov(desde,hasta,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaReporteRango_mov.php?fecha_de='+desde+'&fecha_a='+hasta+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF_mov_pagar(pagina,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generarReportePDF_mov_pagar.php?pagina='+pagina+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF_rango_mov_pagar(desde,hasta,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaReporteRango_mov_pagar.php?fecha_de='+desde+'&fecha_a='+hasta+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF(pagina,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaReporte.php?pagina='+pagina+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF_rango(desde,hasta,busqueda){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaReporteRango.php?fecha_de='+desde+'&fecha_a='+hasta+'&busqueda='+busqueda;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarReportePDF_estadoR(desde,hasta){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaReporteEstadoR.php?fecha_de='+desde+'&fecha_a='+hasta;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}


function validPass(){
    var passNuevo = $('#txtNewPassUser').val();
    var confirmPassNuevo = $('#txtPassConfirm').val();
    if (passNuevo != confirmPassNuevo) {
        $('.alertChangePass').html('<p style="color:red;">Las contraseñas no son iguales.</p>');
        $('.alertChangePass').slideDown();
        return false;
    }

    if (passNuevo.length < 4) {
        $('.alertChangePass').html('<p style="color:red;">La contraseña debe ser de 4 caracteres como mínimo.</p>');
        $('.alertChangePass').slideDown();
        return false;
    }
     $('.alertChangePass').html('');
     $('.alertChangePass').slideDown();
}

//Anular factura
function anularFactura(){
    var noFactura = $('#no_factura').val();
    var action = 'anularFactura';

    $.ajax({
            url : 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,noFactura:noFactura},

            success: function(response)
            {
               if (response == 'error') {
                    $('.alertAddProduct').html('<p style="color:red;">Error al anular la venta.</p>');
               }else{
                    $('#row_'+noFactura+' .estado').html('<span class="anulada">Anulada</span>');
                    $('#form_anular_factura .btn_ok').remove();
                    $('#row_'+noFactura+' .div_factura').html('<button type="button" class="btn_anular inactive" ><i class="fas fa-ban"></i></button>');
                    $('.alertAddProduct').html('<p>Venta anulada.</p>');
               }
            },
            error: function(error){

            }
    });
}

//Anular compra
function anularFacturaCompra(){
    var noFactura = $('#no_factura').val();
    var action = 'anularFactCompra';

    $.ajax({
            url : 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,noFactura:noFactura},

            success: function(response)
            {
               if (response == 'error') {
                    $('.alertAddProduct').html('<p style="color:red;">Error al anular la compra.</p>');
               }else{
                    $('#row_'+noFactura+' .estado').html('<span class="anulada">Anulada</span>');
                    $('#form_anular_factura .btn_ok').remove();
                    $('#row_'+noFactura+' .div_factura').html('<button type="button" class="btn_anular inactive" ><i class="fas fa-ban"></i></button>');
                    $('.alertAddProduct').html('<p>Compra anulada correctamente.</p>');
               }
            },
            error: function(error){

            }
    });
}

function generarPDF_compra(cliente,factura){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaCompra.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarPDF(cliente,factura){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function generarPDFTicket(cliente,factura){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaTicket.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function del_product_detalle(correlativo){
     var action = 'delProductoDetalle';
     var descuento = $('#descuneto_venta').val();
     var id_detalle = correlativo;

     if (descuento == '') {
        descuento = 0;
     }

       $.ajax({
                url : 'ajax.php',
                type : "POST",
                async : true,
                data : {action:action,id_detalle:id_detalle,descuento:descuento},

                success: function(response)
                {
                    //console.log(response);
                    if (response != 'error') 
                    {
                        var info = JSON.parse(response);

                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#txt_cod_producto').val('');
                        $('#txt_descripcion').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');
                        $('#txt_cod_producto').focus();

                        //Bloquear cantidad
                        $('#txt_cant_producto').attr('disabled','disabled');

                        //Ocultar boton agregar
                        $('#add_product_venta').slideUp();

                    }else{
                        $('#detalle_venta').html('');
                         $('#detalle_totales').html('');
                    }
                    viewProcesar();
                   
                },
                error: function(error){

                }
            });

}

//Mostrar/Ocultar boton procesar
function viewProcesar(){
    if ($('#detalle_venta tr').length > 0) 
    {
        $('#btn_facturar_venta').show();
        $('#btn_anular_venta').show();
    }else{
        $('#btn_facturar_venta').hide();
        $('#btn_anular_venta').hide();
    }
}

//Mostrar/Ocultar boton procesar
function viewProcesarCompra(){
    if ($('#detalle_venta_compra tr').length > 0) 
    {
        $('#btn_facturar_compra').show();
        $('#btn_anular_compra').show();
    }else{
        $('#btn_facturar_compra').hide();
        $('#btn_anular_compra').hide();
    }
}

function serchForDetalle(id,descuento){
    var action = 'serchForDetalle';
    var descuento = descuento;
    var user = id;
    if (descuento == '') {
        descuento = 0;
    }

       $.ajax({
                url : 'ajax.php',
                type : "POST",
                async : true,
                data : {action:action,user:user,descuento:descuento},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                     }else{
                        console.log('no data');

                     }
                     viewProcesar();
                },
                error: function(error){

                }
            });
}

function getUrl() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}

function sendDataProduct(){

    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){            
              if (response == 'error')
               {
                 $('alertAddProduct').html('<p style="color: red;">Error al agregar el producto.</p>');
               }else{
                    var info = JSON.parse(response);
                    $('.row'+info.producto_id+' .celPrecio').html(info.nuevo_precio);
                    $('.row'+info.producto_id+' .celExistencia').html(info.nueva_existencia);
                    $('#txtCantidad').val('');
                    $('#txtPrecio').val('');
                    $('.alertAddProduct').html('<p>Producto guardado correctamente.</p>');
               }
               
            },

            error: function(error){
                console.log(error);
            }
     
        });
    
}

//Eliminar Producto
function delProduct(){

    var pr = $('#producto_id').val();
    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_del_product').serialize(),

            success: function(response){            
              if (response == 'error')
               {
                 $('alertAddProduct').html('<p style="color: red;">Error al eliminar el producto.</p>');
               }else{
                    $('.row'+pr).remove();
                    $('#form_del_product .btn_ok').remove();
                    $('.alertAddProduct').html('<p>Producto eliminado correctamente.</p>');
               }
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

function coloseModal(){

    $('.alertAddProduct').html('');
    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    $('.modal').fadeOut();
    $('.modalBuscarCl').fadeOut();
    $('.modalBuscarPr').fadeOut();
    $('.modalBuscarPrCompra').fadeOut();
}


function agregarCliente(id){
 
        var cl = id;
         var action ='searchCliente';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,cliente:cl},

            success: function(response)
            {

                    var data = $.parseJSON(response);
                    $('#nit_cliente').val(data.nit);
                
            },
            error: function(error){
            }
        });

        $('.modalBuscarCl').fadeOut();
        $('#nit_cliente').focus();

           
     }

function serchForDetalleCli(pagina,busqueda){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_cliente_2.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda},

                success: function(response)
                {
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#dataCliente').html(info.detalle);
                        $('#paginadorCliente').html(info.totales);

                     }else{
                        $('#dataCliente').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Nit</th>'+
                                                        '<th>Nombre</th>'+
                                                        '<th>Teléfono</th>'+
                                                        '<th>Dirección</th>'+
                                                        '<th>Acción</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorCliente').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}     

function serchForDetalleProd(busquedaProd,pagina){
        var pagina= pagina;
       $.ajax({
                url : 'action/data_producto.php',
                type : "POST",
                data : {pagina:pagina,busquedaProd:busquedaProd},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#dataProd').html(info.detalle);
                        $('#paginadorProd').html(info.totales);

                     }else{
                        $('#dataProd').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Código</th>'+
                                                        '<th>Descripción</th>'+
                                                        '<th>Existencia</th>'+
                                                        '<th>Precio</th>'+
                                                        '<th>Foto</th>'+
                                                        '<th>Cantidad</th>'+
                                                        '<th>Acción</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                        $('#paginadorProd').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }                  
                
            });
}

function agregarProducto(codigo){
            //$('.alertAddProduct').html('');
            var codproducto = codigo;
            var existencia = parseInt($('#txt_existencia_venta').val());
            var cantidad = $('#txt_cant_producto_venta').val();

            if (cantidad > existencia){
                alert('No hay inventarios suficiente.');
                return false;
            }

            $.ajax({
                url : 'ajax.php',
                type : "POST",
                async : true,
                data: $('#form_del_product').serialize(),
                success: function(response)
                {
                    //console.log(response);
                    if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#busquedaProd').val('');
                        $('#busquedaProd').focus();
                        $('.modal').fadeOut();

                     }else{
                        alert('No se encontro el producto');
                        console.log('no data');

                     }
                     viewProcesar();
                },
                error: function(error){
                }
            });

    
    //location.reload();
    //$('.modalBuscarPr').fadeIn();
}
//Lista de clientes
function listaCliente(busqueda,pagina,cantidad){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_cliente.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaCliente').html(info.detalle);
                        $('#paginadorClient').html(info.totales);

                     }else{
                        $('#listaCliente').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Nit</th>'+
                                                        '<th>Nombre</th>'+
                                                        '<th>Teléfono</th>'+
                                                        '<th>Dirección</th>'+
                                                        '<th>Acción</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorClient').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

   //Modal editar cliente//
   function editarCliente(id)
     {
        var cliente = id;
        var action = 'editarCliente';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); actualizarCliente();">'+
                                            '<input type="hidden" name="action" value="actualizarCliente">'+
                                            '<h1><i class="fas fa-user" style="font-size: 45pt;"></i> <br> Actualizar cliente</h1>'+
                                            '<input type="hidden" name="idCliente" value="'+info.idcliente+'">'+
                                            '<input type="text" name="nitCliente" id="nitCliente" value="'+info.nit+'" placeholder="Nit" required><br>'+
                                            '<input type="text" name="nombreCliente" id="nombreCliente" value="'+info.nombre+'" placeholder="Nombre y apellidos" onkeypress="return soloLetras(event)" onpaste="return false" required><br>'+
                                            '<input type="number" name="telefonoCliente" id="telefonoCliente" value="'+info.telefono+'" placeholder="Teléfono" required><br>'+
                                            '<input type="text" name="direccionCliente" id="direccionCliente" value="'+info.direccion+'" placeholder="Dirección" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

   function actualizarCliente(){

    $('.alertAddProduct').html('');
    var nit = $('#nitCliente').val();
    var nombre = $('#nombreCliente').val();
    var telefono = $('#telefonoCliente').val();
    var direccion = $('#direccionCliente').val();
    var busquedaCli = $('#busquedaCliente').val();
    if (nit.length < 5){
        $('.alertAddProduct').html('<p style="color:red;">El NIT debe ser de 5 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (nombre.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El Nombre debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (telefono.length < 8){
        $('.alertAddProduct').html('<p style="color:red;">El telefono debe ser de 8 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (direccion.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">La direccion debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){          

                    var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaCliente(busquedaCli,1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
            },

            error: function(error){
                console.log(error);
            }
     
        });    
}

//Modal eliminar cliente//
   function infoEliminarCliente(id)
     {
        var cliente = id;
        var action = 'editarCliente';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); eliminarCliente();">'+
                                            '<input type="hidden" name="action" value="eliminarCliente">'+
                                            '<h1><i class="fas fa-user" style="font-size: 45pt;"></i> <br> Eliminar cliente</h1>'+
                                            '<input type="hidden" name="cliente_id" id="cliente_id" value="'+info.idcliente+'">'+
                                            '<p>¿Está seguro de eliminar el siguiente registro?</p>'+
                                            '<h2 class="nameProducto">'+info.nombre+'</h2> <br>'+
                                            '<h2 class="nameProducto">'+info.nit+'</h2> <br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Eliminar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Eliminar cliente
function eliminarCliente(){

    var cliente = $('#cliente_id').val();
    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){            
              if (response == 'error')
               {
                 $('alertAddProduct').html('<p style="color: red;">Error al eliminar el cliente.</p>');
               }else{
                    $('.row'+cliente).remove();
                    $('#form_add_product .btn_new').remove();
                    $('.alertAddProduct').html('<p>Cliente eliminado correctamente.</p>');
                    listaCliente('',1,10);
               }
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}


    //Registrar cliente
function nuevoCliente(){

    $('.alertAddProduct').html('');
    var nit = $('#nitCliente').val();
    var nombre = $('#nombreCliente').val();
    var telefono = $('#telefonoCliente').val();
    var direccion = $('#direccionCliente').val();
    if (nit.length < 5){
        $('.alertAddProduct').html('<p style="color:red;">El NIT debe ser de 5 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (nombre.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El Nombre debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (telefono.length < 8){
        $('.alertAddProduct').html('<p style="color:red;">El telefono debe ser de 8 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (direccion.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">La direccion debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaCliente('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

//Lista de usuarios
function listaUsuario(busqueda,pagina,cantidad){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_usuario.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaUsuario').html(info.detalle);
                        $('#paginadorUsuario').html(info.totales);

                     }else{
                        $('#listaUsuario').html('<table>'+
                                                    '<tr>'+
                                                        '<th>ID</th>'+
                                                        '<th>Nombre</th>'+
                                                        '<th>Correo</th>'+
                                                        '<th>Usuario</th>'+
                                                        '<th>Rol</th>'+
                                                        '<th>Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorUsuario').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

   //Modal editar Usuario
   function editarUsuario(id)
     {
        var usuario = id;
        var action = 'editarUsuario';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,usuario:usuario},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); actualizarUsuario();">'+
                                            '<input type="hidden" name="action" value="actualizarUsuario">'+
                                            '<h1><i class="fas fa-user" style="font-size: 45pt;"></i> <br> Actualizar usuario</h1>'+
                                            '<input type="hidden" name="idUsuario" value="'+info.usuario.idusuario+'">'+
                                            '<input type="text" name="nombreUsuario" id="nombreUsuario" value="'+info.usuario.nombre+'" placeholder="Nombre y apellidos" onkeypress="return soloLetras(event)" onpaste="return false" required><br>'+
                                            '<input type="email" name="correoUsuario" id="correoUsuario" value="'+info.usuario.correo+'" placeholder="Correo electrónico" required><br>'+
                                            '<input type="text" name="usuario" id="usuario" value="'+info.usuario.usuario+'" placeholder="Usuario" required><br>'+
                                            '<input type="password" name="claveUsuario" id="claveUsuario" value="" placeholder="Clave"><br>'+
                                            '<select name="rolUsuario" id="rolUsuario" required><option value="'+info.usuario.idrol+'">'+info.usuario.rol+'</option>'+info.rol+'</select><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Actualizar usuarios
   function actualizarUsuario(){
    $('.alertAddProduct').html('');
    var nombre = $('#nombreUsuario').val();
    var usuario = $('#usuario').val();
    var clave = $('#claveUsuario').val();
    var busquedaUsu = $('#busquedaUsuario').val();
    if (nombre.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El Nombre debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (usuario.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El Usuario debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    
    if($("#correoUsuario").val().indexOf('@', 0) == -1 || $("#correoUsuario").val().indexOf('.', 0) == -1) {
        $('.alertAddProduct').html('<p style="color:red;">El correo electrónico no es correcto.</p>');
            return false;
        }

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){          
//console.log(response);
                    var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaUsuario(busquedaUsu,1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
            },

            error: function(error){
                console.log(error);
            }
     
        });    
}

//Modal eliminar usuario//
   function infoEliminarUsuario(id)
     {
        var usuario = id;
        var action = 'editarUsuario';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,usuario:usuario},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); eliminarUsuario();">'+
                                            '<input type="hidden" name="action" value="eliminarUsuario">'+
                                            '<h1><i class="fas fa-user" style="font-size: 45pt;"></i> <br> Eliminar usuario</h1>'+
                                            '<input type="hidden" name="usuario_id" id="usuario_id" value="'+info.usuario.idusuario+'">'+
                                            '<p>¿Está seguro de eliminar el siguiente registro?</p>'+
                                            '<h2 class="nameProducto">'+info.usuario.nombre+'</h2> <br>'+
                                            '<h2 class="nameProducto">'+info.usuario.usuario+'</h2> <br>'+
                                            '<h2 class="nameProducto">'+info.usuario.rol+'</h2> <br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Eliminar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Eliminar Usuario
function eliminarUsuario(){

    var usuario = $('#usuario_id').val();
    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){            
              if (response == 'error')
               {
                 $('alertAddProduct').html('<p style="color: red;">Error al eliminar el usuario.</p>');
               }else{
                    $('.row'+usuario).remove();
                    $('#form_add_product .btn_new').remove();
                    $('.alertAddProduct').html('<p>Usuario eliminado correctamente.</p>');
                    listaUsuario('',1,10);
               }
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}


    //Registrar usuario
function nuevoUsuario(){

    $('.alertAddProduct').html('');
    var nombre = $('#nombreUsuario').val();
    var usuario = $('#usuario').val();
    var clave = $('#claveUsuario').val();
    if (nombre.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El Nombre debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (usuario.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El Usuario debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    if (clave.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">La contraseña debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    
    if($("#correoUsuario").val().indexOf('@', 0) == -1 || $("#correoUsuario").val().indexOf('.', 0) == -1) {
        $('.alertAddProduct').html('<p style="color:red;">El correo electrónico no es correcto.</p>');
            return false;
        }


    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){            
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaUsuario('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

//Lista de proveedor
function listaProveedor(busqueda,pagina,cantidad){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_proveedor.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        //console.log(response);
                        $('#listaProveedor').html(info.detalle);
                        $('#paginadorProveedor').html(info.totales);

                     }else{
                        $('#listaProveedor').html('<table>'+
                                                    '<tr>'+
                                                        '<th>ID</th>'+
                                                        '<th>Proveedor</th>'+
                                                        '<th>Contacto</th>'+
                                                        '<th>Teléfono</th>'+
                                                        '<th>Dirección</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorProveedor').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

//Modal editar proveedor//
   function editarProveedor(id)
     {
        var proveedor = id;
        var action = 'editarProveedor';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,proveedor:proveedor},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); actualizarProveedor();">'+
                                            '<input type="hidden" name="action" value="actualizarProveedor">'+
                                            '<h1><i class="fas fa-user" style="font-size: 45pt;"></i> <br> Actualizar proveedor</h1>'+
                                            '<input type="hidden" name="idProveedor" value="'+info.codproveedor+'">'+
                                            '<input type="text" name="nombreProveedor" id="nombreProveedor" value="'+info.proveedor+'" placeholder="Nombre de proveedor" onkeypress="return soloLetras(event)" onpaste="return false" required><br>'+
                                            '<input type="text" name="nombreContacto" id="nombreContacto" value="'+info.contacto+'" placeholder="Nombre del contacto" onkeypress="return soloLetras(event)" onpaste="return false" required><br>'+
                                            '<input type="number" name="telefonoProveedor" id="telefonoProveedor" value="'+info.telefono+'" placeholder="Teléfono" required><br>'+
                                            '<input type="text" name="direccionProveedor" id="direccionProveedor" value="'+info.direccion+'" placeholder="Dirección" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Actualizar proveedor
   function actualizarProveedor(){

    $('.alertAddProduct').html('');
    var nombre = $('#nombreProveedor').val();
    var contacto = $('#nombreContacto').val();
    var telefono = $('#telefonoProveedor').val();
    var direccion = $('#direccionProveedor').val();
    var busquedaProv = $('#busquedaProveedor').val();
    if (nombre.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El Nombre debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
     if (contacto.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El contacto debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
     if (telefono.length < 8){
        $('.alertAddProduct').html('<p style="color:red;">El Teléfono debe ser de 8 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
     if (direccion.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">La Dirección debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){          

                    var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaProveedor(busquedaProv,1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
            },

            error: function(error){
                console.log(error);
            }
     
        });    
}

//Modal eliminar proveedor//
   function infoEliminarProveedor(id)
     {
        var proveedor = id;
        var action = 'editarProveedor';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,proveedor:proveedor},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); eliminarProveedor();">'+
                                            '<input type="hidden" name="action" value="eliminarProveedor">'+
                                            '<h1><i class="fas fa-user" style="font-size: 45pt;"></i> <br> Eliminar proveedor</h1>'+
                                            '<input type="hidden" name="proveedor_id" id="proveedor_id" value="'+info.codproveedor+'">'+
                                            '<p>¿Está seguro de eliminar el siguiente registro?</p>'+
                                            '<h2 class="nameProducto">'+info.proveedor+'</h2> <br>'+
                                            '<h2 class="nameProducto">'+info.contacto+'</h2> <br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Eliminar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Eliminar proveedor
function eliminarProveedor(){

    var proveedor = $('#proveedor_id').val();
    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){            
              if (response == 'error')
               {
                 $('alertAddProduct').html('<p style="color: red;">Error al eliminar el proveedor.</p>');
               }else{
                    $('.row'+proveedor).remove();
                    $('#form_add_product .btn_new').remove();
                    $('.alertAddProduct').html('<p>Proveedor eliminado correctamente.</p>');
                    listaProveedor('',1,10);
               }
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}


    //Registrar proveedor
function nuevoProveedor(){

    $('.alertAddProduct').html('');
    var nombre = $('#nombreProveedor').val();
    var contacto = $('#nombreContacto').val();
    var telefono = $('#telefonoProveedor').val();
    var direccion = $('#direccionProveedor').val();
    if (nombre.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El Nombre debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
     if (contacto.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">El contacto debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
     if (telefono.length < 8){
        $('.alertAddProduct').html('<p style="color:red;">El Teléfono debe ser de 8 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
     if (direccion.length < 4){
        $('.alertAddProduct').html('<p style="color:red;">La Dirección debe ser de 4 caracteres como mínimo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }
    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){            
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaProveedor('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

//Lista de productos
function listaProductos(busqueda,pagina,cantidad){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_producto1.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaProducto').html(info.detalle);
                        $('#paginadorProducto').html(info.totales);

                     }else{
                        $('#listaProducto').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Código</th>'+
                                                        '<th>Descripción</th>'+
                                                        '<th>Precio</th>'+
                                                        '<th>Existencia</th>'+
                                                        '<th>Proveedor</th>'+
                                                        '<th>Foto</th>'+
                                                        '<th>Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorProducto').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

//Agregar producto
 function agregarProd(id){
        var producto = id;
        var action = 'infoProducto';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){            
                if (response != 'error') {
                   //console.log(response);
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Agregar Producto</h1>'+
                                            '<h2 class="nameProducto">'+info.descripcion+'</h2> <br>'+
                                            '<input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del producto" required><br>'+
                                            '<input type="text" name="precio" id="txtPrecio" placeholder="Precio del producto" required>'+
                                            '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                            '<input type="hidden" name="action" value="addProduct" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Modal editar producto
   function editarProducto(id)
     {
        var producto = id;
        var action = 'editarProducto';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    foto = '';
                    classRemove = '';
                    if (info.producto.foto != 'img_producto.png'){
                        classRemove = '';
                        foto = '<img id="img" src="img/uploads/'+info.producto.foto+'" alt="Producto">';
                    }else{
                        classRemove = 'notBlock';
                        foto = '<img id="img" src="img/'+info.producto.foto+'" alt="Producto">';
                    }
                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); actualizarProducto();">'+
                                            '<input type="hidden" name="action" value="actualizarProducto">'+
                                            '<h1><i class="fa fa-cube" style="font-size: 45pt;"></i> <br> Actualizar producto</h1>'+
                                            '<input type="hidden" name="idProducto" value="'+info.producto.codproducto+'">'+
                                            '<select name="nombreProveedorProd" id="nombreProveedorProd" required><option value="'+info.producto.codproveedor+'">'+info.producto.proveedor+'</option>'+info.proveedor+'</select><br>'+
                                            '<input type="text" name="codigoProducto" id="codigoProducto" value="'+info.producto.codigo+'" placeholder="Código del producto" required><br>'+
                                            '<input type="text" name="nombreProducto" id="nombreProducto" value="'+info.producto.descripcion+'" placeholder="Nombre del producto" required><br>'+
                                            '<input step="any" type="number" name="costoProducto" id="costoProducto" value="'+info.producto.costo+'" placeholder="Costo del producto" required><br>'+
                                            '<input step="any" type="number" name="prcioProducto" id="prcioProducto" value="'+info.producto.precio+'" placeholder="Prcio del producto" required>'+
                                            '<div class="photo"><label for="foto"></label><div class="prevPhoto">'+
                                            '<span class="'+classRemove+'"></span>'+
                                            '<label for="foto"></label>'+foto+'</div><div class="upimg"></div><br>'+
                                            '<input type="file" name="foto" id="foto">'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

 //Actualizar producto
   function actualizarProducto(){

    $('.alertAddProduct').html('');
    var parametros = new FormData($('#form_add_product')[0]);
    var busquedaProd = $('#busquedaProducto').val();

    $.ajax({
            url:'ajax.php',
            type:'POST',
            data: parametros,
            contentType: false,
            processData: false,

            success: function(response){          
                    //console.log(response);
                    var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaProductos(busquedaProd,1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
            },

            error: function(error){
                console.log(error);
            }
     
        });    
}

//Modal eliminar producto//
   function infoEliminarProducto(id)
     {
        var producto = id;
        var action = 'editarProducto';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); eliminarProducto();">'+
                                            '<input type="hidden" name="action" value="eliminarProducto">'+
                                            '<h1><i class="fas fa-user" style="font-size: 45pt;"></i> <br> Desactivar producto</h1>'+
                                            '<input type="hidden" name="producto_id2" id="producto_id2" value="'+info.producto.codproducto+'">'+
                                            '<p>¿Está seguro de eliminar el siguiente registro?</p>'+
                                            '<h2 class="nameProducto">'+info.producto.proveedor+'</h2> <br>'+
                                            '<h2 class="nameProducto">'+info.producto.descripcion+'</h2> <br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Desactivar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Eliminar producto
function eliminarProducto(){

    var producto = $('#producto_id2').val();
    var descripcion = $('#busquedaProducto').val();
    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){            
              if (response == 'error')
               {
                 $('alertAddProduct').html('<p style="color: red;">Error al eliminar el producto.</p>');
               }else{
                    $('.row'+producto).remove();
                    $('#form_add_product .btn_new').remove();
                    $('.alertAddProduct').html('<p>Producto eliminado correctamente.</p>');
                    listaProductos(descripcion,1,10);
               }
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}


    //Registrar producto
function nuevoProducto(){

    var parametros = new FormData($('#form_add_product')[0]);
    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:"POST",
            data: parametros,
            contentType: false,
            processData:false,

            success: function(response){  
            //console.log(response);          
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaProductos('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

//Lista ventas
function listaVentas(busqueda,pagina,cantidad){
         var pagina= pagina;
       $.ajax({
                url : 'action/data_ventas.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaVentas').html(info.detalle);
                        $('#paginadorVentas').html(info.totales);

                     }else{
                        $('#listaVentas').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Cliente</th>'+
                                                        '<th>Vendedor</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th class="textright">Total Factura</th>'+
                                                        '<th class="textright">Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorVentas').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

//Modal Form Anular Factura
    function infoAnularFactura(nofactura){
        /*Act on the event*/
        //e.preventDefault();
        var nofactura = nofactura;
        var action = 'infoFactura';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,nofactura:nofactura},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);


                   $('.bodyModal').html('<form action="" method="post" name="form_anular_factura" id="form_anular_factura" onsubmit="event.preventDefault(); anularFactura();">'+
                                            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Anular Venta</h1><br>'+
                                            '<p>¿Realmente desea anular la venta?</p>'+
                                            '<p><strong>No. '+info.noventa+'</strong></p>'+
                                            '<p><strong>Monto. C$ '+info.totalventa+'</strong></p>'+
                                            '<p><strong>Fecha. '+info.fecha+'</strong></p>'+
                                            '<input type="hidden" name="action" value="anularFactura">'+
                                            '<input type="hidden" name="no_factura" id="no_factura" value="'+info.noventa+'" required>'+
                                           
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Anular</button>'+             
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Modal Form Anular Factura
    function infoAnularFacturaCompra(nofactura){
        /*Act on the event*/
        //e.preventDefault();
        var nofactura = nofactura;
        var action = 'infoCompra';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,nofactura:nofactura},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);


                   $('.bodyModal').html('<form action="" method="post" name="form_anular_factura" id="form_anular_factura" onsubmit="event.preventDefault(); anularFacturaCompra();">'+
                                            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Anular Compra</h1><br>'+
                                            '<p>¿Realmente desea anular la compra?</p>'+
                                            '<p><strong>No. '+info.nocompra+'</strong></p>'+
                                            '<p><strong>Monto. C$ '+info.totalcompra+'</strong></p>'+
                                            '<p><strong>Fecha. '+info.fecha+'</strong></p>'+
                                            '<input type="hidden" name="action" value="anularFactura">'+
                                            '<input type="hidden" name="no_factura" id="no_factura" value="'+info.nocompra+'" required>'+
                                           
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Anular</button>'+             
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }
        //Ver compra
        function verFacturaCompra(codcliente,nofactura){
        var codCliente = codcliente;
        var noFactura = nofactura;
        generarPDF_compra(codCliente,noFactura);
    }


    //Ver Factura
    function verFactura(codcliente,nofactura){
        var codCliente = codcliente;
        var noFactura = nofactura;
        generarPDF(codCliente,noFactura);
    }

    //Ver Factura
    function verTicket(codcliente,nofactura){
        var codCliente = codcliente;
        var noFactura = nofactura;
        generarPDFTicket(codCliente,noFactura);
    }

    //Agregar producto al detalle con enter
    function agregarProductoAlDetalle(){
        if ($('#txt_cant_producto').val() > 0)
        { 
            var codproducto = $('#txt_id_producto').val();
            var cantidad = $('#txt_cant_producto').val();
            var existencia = parseInt($('#txt_existencia').html());
            var precio = $('#txt_precio').val();
            var action = 'addProductoDetalle';
           if (cantidad > existencia){
                alert('No hay inventario suficiente.');
                return false;
            }
            

            $.ajax({
                url : 'ajax.php',
                type : "POST",
                async : true,
                data : {action:action,producto:codproducto,cantidad:cantidad,precio:precio},
                success: function(response)
                {
                    //console.log(response);
                    if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#txt_id_producto').val('');
                        $('#txt_cod_producto').val('');
                        $('#txt_descripcion').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').val('0.00');
                        $('#txt_precio_total').html('0.00');

                        //Bloquear cantidad
                        $('#txt_cant_producto').attr('disabled','disabled');
                        $('#txt_precio').attr('disabled','disabled');
                        $('#txt_id_producto').attr('disabled','disabled');

                        //Ocultar boton agregar
                        $('#add_product_venta').slideUp();
                        $('#txt_cod_producto').focus();

                     }else{
                        console.log('no data');

                     }
                     viewProcesar();

                },
                error: function(error){

                }
            });
        }
    }

    function facturar(){
        var rows = $('#detalle_venta tr').length;
        if (rows > 0) 
        {
            var action = 'procesarVenta';
            var codcliente = $('#idcliente').val();
            var tipoPago = $('#tipo_pago').val();
            var descuento = $('#descuneto_venta').val();
            var comprobante = $('#comprobante').val();
            if (descuento == '') {
                descuento = 0;
            }

            $.ajax({
                url : 'ajax.php',
                type: "POST",
                async : true,
                data: {action:action,codcliente:codcliente,tipoPago:tipoPago,descuento:descuento},

                success: function(response)
                {
                    console.log(response);
                    if (response != 'error')
                    {
                        var info = JSON.parse(response);
                        if (comprobante ==1) {
                            generarPDFTicket(info.codcliente,info.noventa);
                        }else if(comprobante ==2){
                            generarPDF(info.codcliente,info.noventa);                       
                        }
                            location.reload();
                    }else{
                        console.log('no data');
                    }
                },
                error: function(error){
                }
            });
        }
    }

    function anularVent(){
        var rows = $('#detalle_venta tr').length;
        if (rows > 0) 
        {
            var action = 'anularVenta';

            $.ajax({
                url : 'ajax.php',
                type: "POST",
                async : true,
                data: {action:action},

                success: function(response)
                {
                    if (response != 'error')
                    {
                        location.reload();
                    }
                },
                error: function(error){
                }
            });
        }
    }

     function anularCompra(){
        var rows = $('#detalle_venta_compra tr').length;
        if (rows > 0) 
        {
            var action = 'anularCompra';

            $.ajax({
                url : 'ajax.php',
                type: "POST",
                async : true,
                data: {action:action},

                success: function(response)
                {
                    if (response != 'error')
                    {
                        location.reload();
                    }
                },
                error: function(error){
                }
            });
        }
    }

 function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }

  //Modal activar producto//
   function infoActivarProducto(id)
     {
        var producto = id;
        var action = 'editarProducto';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); activarProducto();">'+
                                            '<input type="hidden" name="action" value="activarProducto">'+
                                            '<h1><i class="fas fa-user" style="font-size: 45pt;"></i> <br> Activar este producto?</h1>'+
                                            '<input type="hidden" name="producto_id_2" id="producto_id_2" value="'+info.producto.codproducto+'">'+
                                            '<p>¿Está seguro de activar el siguiente producto?</p>'+
                                            '<h2 class="nameProducto">'+info.producto.proveedor+'</h2> <br>'+
                                            '<h2 class="nameProducto">'+info.producto.descripcion+'</h2> <br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Activar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

        //Activar producto
function activarProducto(){

    var producto = $('#producto_id_2').val();
    var descripcion = $('#busquedaProducto').val();
    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){            
              if (response == 'error')
               {
                 $('alertAddProduct').html('<p style="color: red;">Error al activar el producto.</p>');
               }else{
                    $('.row'+producto).remove();
                    $('#form_add_product .btn_new').remove();
                    $('.alertAddProduct').html('<p>Producto activado correctamente.</p>');
                    listaProductos(descripcion,1,10);
               }
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}
//Lista de creditos
function listaCreditos(busqueda,pagina){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_credito.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#cuentas_por_cobrar').html(info.detalle);
                        $('#paginador_por_cobrar').html(info.totales);

                     }else{
                        $('#cuentas_por_cobrar').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Cliente</th>'+
                                                        '<th>Vendedor</th>'+
                                                        '<th>Total factura</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th>Acción</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginador_por_cobrar').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

//Lista Movimientos
function listaMovimientos(busqueda,pagina,cantidad){
         var pagina= pagina;
         var busqueda = $('#busquedaMov').val();
       $.ajax({
                url : 'action/data_movimientos.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaMovimientos').html(info.detalle);
                        $('#paginadorMovimientos').html(info.totales);

                     }else{
                        $('#listaMovimientos').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Cliente</th>'+
                                                        '<th>Vendedor</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th class="textright">Total Factura</th>'+
                                                        '<th class="textright">Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorMovimientos').html('');
                        console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

//Modal  agregar nueva factura//
   function add_fact_cliente(id)
     {
        var cliente = id;
        var action = 'info_cuenta_cobrar';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);
                    var saldo = info.totalventa - info.abono;


                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); nueva_factura_cobrar();">'+
                                            '<input type="hidden" name="action" value="add_factura_cliente">'+
                                            '<h1><i class="fa fa-file-alt fa-w-12" style="font-size: 45pt;"></i> <br> <br>Agregar Factura</h1>'+
                                            '<input type="hidden" name="id_client_fact" id="id_client_fact" value="'+info.codcliente+'">'+
                                            '<p>¿Está seguro de agregar la siguiente factura?</p>'+
                                            '<h2>Nombre: '+info.cliente+'</h2>'+
                                            '<h2>Saldo: C$ '+saldo+'</h2>'+
                                            '<label style="text-align: left;">Cantidad:</label>'+
                                            '<input type="number" step="any" name="nuevaFactura" id="nuevaFactura" value="" placeholder="C$ 0.00" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Registrar nueva factura
function nueva_factura_cobrar(){

    $('.alertAddProduct').html('');
    var id = $('#id_client_fact').val();
    var cantidad = $('#nuevaFactura').val();

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaCreditos('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

//Modal agregar nuevo pago//
   function add_abono_cliente(cliente,nofactura)
     {
        var nofactura = nofactura;
        var cliente = cliente;
        var action = 'info_cuenta_cobrar';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,cliente:cliente,nofactura:nofactura},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);
                    var saldo = info.totalventa - info.abono;

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); nuevo_abono_clinete();">'+
                                            '<input type="hidden" name="action" value="add_abono_cliente">'+
                                            '<h1><i class="fas fa-money-bill-alt" style="font-size: 45pt;"></i> <br> <br>Realizar Pago</h1>'+
                                            '<input type="hidden" name="id_venta_abono" id="id_venta_abono" value="'+info.noventa+'">'+
                                            '<input type="hidden" name="id_client_abono" id="id_client_abono" value="'+info.codcliente+'">'+
                                            '<input type="hidden" name="id_client_saldo" id="id_client_saldo" value="'+saldo+'">'+
                                            '<p>¿Está seguro de realizar el siguiente pago?</p>'+
                                            '<h2>Nombre: '+info.cliente+'</h2>'+
                                            '<h2>Saldo: C$ '+saldo+'</h2>'+
                                            '<label class="textcenter">Cantidad:</label>'+
                                            '<input class="textcenter" type="number" step="any" name="nuevoAbono" id="nuevaAbono" value="" placeholder="C$ 0.00" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Registrar nuevo abono
function nuevo_abono_clinete(){

    $('.alertAddProduct').html('');
    var id = $('#id_client_abono').val();
    var nofactura = $('#id_venta_abono').val();
    var cantidad = $('#nuevaAbono').val();
    var saldo = parseInt($('#id_client_saldo').val());

    if (saldo < cantidad) {
        $('.alertAddProduct').html('<p style="color:red;">La cantidad debe ser menor o igual que saldo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            generarReciboPDF(id,info.msg);
                            $('#form_add_product')[0].reset();
                            listaCreditos('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }

                        $('.modal').fadeOut();
                        //listaMovimientos();
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });

}

//Agregar new factura
function new_fact_cobrar(){

    $('.alertAddProduct').html('');
    var cliente = $('#new_cliente_fact').val();
    var noDoc = $('#new_num_fact').val();
    var cantidad = $('#new_fact').val();

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#agregar_new_factura').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#agregar_new_factura')[0].reset();
                            listaCreditos('',1,11);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

//Lista Recibos
function listaRecibos(pagina,busqueda){
         var pagina = pagina;
         var busqueda = $('#busquedaRecibo').val();
       $.ajax({
                url : 'action/data_recibo.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaRecibos').html(info.detalle);
                        $('#paginadorRecibos').html(info.totales);

                     }else{
                        $('#listaRecibos').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Id.</th>'+
                                                        '<th>No. Venta</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Saldo anterio</th>'+
                                                        '<th>Abono</th>'+
                                                        '<th>Saldo actual</th>'+
                                                        '<th class="textcenter">Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorRecibos').html('');
                        console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

function generarReciboPDF(cliente,factura){
    var ancho = 1000;
    var alto = 800;
    //Calcularposicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generarRecibo.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function verRecibo(codcliente,nofactura){
        var codCliente = codcliente;
        var noFactura = nofactura;
        generarReciboPDF(codCliente,noFactura);
    }

    //Agregar new factura proveedor
function new_fact_pagar(){

    $('.alertAddProduct').html('');
    var cliente = $('#new_proveedor_fact').val();
    var noDoc = $('#new_prov_fact').val();
    var cantidad = $('#cantidad_fact_prov').val();

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#agregar_prov_factura').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#agregar_prov_factura')[0].reset();
                            lista_cuentas_por_pagar('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

//Lista de cuentas por pagar
function lista_cuentas_por_pagar(busqueda,pagina){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_por_pagar.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#cuentas_por_pagar').html(info.detalle);
                        $('#paginador_por_pagar').html(info.totales);

                     }else{
                        $('#cuentas_por_pagar').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Id</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Proveedor</th>'+
                                                        '<th>Total factura</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th>Acción</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginador_por_pagar').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

//Lista Movimientos proveedores
function lista_Mov_proveedor(busqueda,pagina,cantidad){
         var pagina= pagina;
         var busqueda = $('#busquedaMov_proveedor').val();
       $.ajax({
                url : 'action/data_mov_proveedor.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaMov_proveedor').html(info.detalle);
                        $('#paginadorMov_proveedor').html(info.totales);

                     }else{
                        $('#listaMov_proveedor').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Usuario</th>'+
                                                        '<th>Proveedor</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th class="textright">Total Factura</th>'+
                                                        '<th class="textright">Abono</th>'+
                                                        '<th class="textright">Saldo total</th>'+
                                                        '<th class="textright">Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorMov_proveedor').html('');
                        console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

        //Modal agregar nuevo pago proveedor
   function add_abono_proveedor(proveedor,nofactura)
     {
        var nofactura = nofactura;
        var proveedor = proveedor;
        var action = 'info_cuenta_pagar';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,proveedor:proveedor,nofactura:nofactura},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);
                    var saldo = info.totalcompra - info.abono;

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); nuevo_abono_proveedor();">'+
                                            '<input type="hidden" name="action" value="add_abono_proveedor">'+
                                            '<h1><i class="fas fa-money-bill-alt" style="font-size: 45pt;"></i> <br> <br>Realizar Pago</h1>'+
                                            '<input type="hidden" name="id_compra_abono" id="id_compra_abono" value="'+info.nocompra+'">'+
                                            '<input type="hidden" name="id_prov_abono" id="id_prov_abono" value="'+info.codproveedor+'">'+
                                            '<input type="hidden" name="saldo_anterior" id="saldo_anterior" value="'+saldo+'">'+
                                            '<p>¿Está seguro de realizar el siguiente pago?</p>'+
                                            '<h2>Proveedor: '+info.proveedor+'</h2>'+
                                            '<h2>Saldo: C$ '+saldo+'</h2>'+
                                            '<label class="textcenter">Cantidad:</label>'+
                                            '<input class="textcenter" type="number" step="any" name="nuevoAbono_prov" id="nuevoAbono_prov" value="" placeholder="C$ 0.00" required><br>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="coloseModal(); "><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Guardar</button>'+              
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Registrar nuevo abono
function nuevo_abono_proveedor(){

    $('.alertAddProduct').html('');
    var id = $('#id_prov_abono').val();
    var nofactura = $('#id_compra_abono').val();
    var cantidad = $('#nuevoAbono_prov').val();
    var saldo = parseInt($('#saldo_anterior').val());

     if (saldo < cantidad) {
        $('.alertAddProduct').html('<p style="color:red;">La cantidad debe ser menor o igual que saldo.</p>');
        $('.alertAddProduct').slideDown();
        return false;
    }

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            //generarReciboPDF(id,info.msg);
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            lista_cuentas_por_pagar('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }

                        $('.modal').fadeIn();
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });

}

//Lista Recibos proveedor
function listaRecibos_proveedor(pagina,busqueda){
         var pagina = pagina;
         var busqueda = $('#busquedaRecibo_prov').val();
       $.ajax({
                url : 'action/data_recibo_proveedor.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaRecibos_proveedor').html(info.detalle);
                        $('#paginadorRecibos_proveedor').html(info.totales);

                     }else{
                        $('#listaRecibos_proveedor').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Id.</th>'+
                                                        '<th>No. compra.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Saldo anterio</th>'+
                                                        '<th>Abono</th>'+
                                                        '<th>Saldo actual</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorRecibos_proveedor').html('');
                        console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

//Procesar compra
function comprar(){
        var rows = $('#detalle_venta_compra tr').length;
        if (rows > 0) 
        {
            var action = 'procesarCompra';
            var codproveedor = $('#idproveedor').val();
            var tipoPago = $('#tipo_pago').val();

            $.ajax({
                url : 'ajax.php',
                type: "POST",
                async : true,
                data: {action:action,codproveedor:codproveedor,tipoPago:tipoPago},

                success: function(response)
                {
                    //console.log(response);
                    if (response != 'error')
                    {
                        var info = JSON.parse(response);
                        //generarPDF(info.codcliente,info.nofactura)
                        //generarPDFTicket(info.codcliente,info.noventa)
                        location.reload();
                    }else{
                        console.log('no data');
                    }
                },
                error: function(error){
                }
            });
        }
    }

    function serchForDetalleCompra(id){
    var action = 'serchForDetalleCompra';
    var user = id;

       $.ajax({
                url : 'ajax.php',
                type : "POST",
                async : true,
                data : {action:action,user:user},

                success: function(response)
                {
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#detalle_venta_compra').html(info.detalle);
                        $('#detalle_totales_compra').html(info.totales);

                     }else{
                        console.log('no data');

                     }
                     viewProcesarCompra();
                },
                error: function(error){

                }
            });
}

    //Agregar producto al detalle con enter
    function agregarProductoAlDetalleCompra(){
        if ($('#txt_cant_producto_compra').val() > 0)
        { 
            var codproducto = $('#txt_id_producto_compra').val();
            var cantidad = $('#txt_cant_producto_compra').val();
            var costo = $('#txt_precio_compra').val();
            var existencia = parseInt($('#txt_existencia_compra').html());
            var action = 'addProductoDetalleCompra';          

            $.ajax({
                url : 'ajax.php',
                type : "POST",
                async : true,
                data : {action:action,producto:codproducto,cantidad:cantidad,costo:costo},
                success: function(response)
                {
                    //console.log(response);
                    if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#detalle_venta_compra').html(info.detalle);
                        $('#detalle_totales_compra').html(info.totales);

                        $('#txt_id_producto_compra').val('');
                        $('#txt_cod_producto_compra').val('');
                        $('#txt_descripcion_compra').html('-');
                        $('#txt_existencia_compra').html('-');
                        $('#txt_cant_producto_compra').val('0');
                        $('#txt_precio_compra').val('0.00');
                        $('#txt_precio_total_compra').html('0.00');

                        //Bloquear cantidad
                        $('#txt_cant_producto_compra').attr('disabled','disabled');
                        $('#txt_precio_compra').attr('disabled','disabled');
                        $('#txt_id_producto_compra').attr('disabled','disabled');

                        //Ocultar boton agregar
                        $('#add_product_venta').slideUp();
                        $('#txt_cod_producto_compra').focus();

                     }else{
                        console.log('no data');

                     }
                     viewProcesarCompra();

                },
                error: function(error){

                }
            });
        }
    }

//Borrar producto del detalle temporal
    function del_product_detalle_compra(correlativo){
     var action = 'delProductoDetalleCompra';
     var id_detalle = correlativo;

       $.ajax({
                url : 'ajax.php',
                type : "POST",
                async : true,
                data : {action:action,id_detalle:id_detalle},

                success: function(response)
                {
                    //console.log(response);
                    if (response != 'error') 
                    {
                        var info = JSON.parse(response);

                        $('#detalle_venta_compra').html(info.detalle);
                        $('#detalle_totales_compra').html(info.totales);

                        $('#txt_cod_producto_compra').val('');
                        $('#txt_descripcion_compra').html('-');
                        $('#txt_existencia_compra').html('-');
                        $('#txt_cant_producto_compra').val('0');
                        $('#txt_precio_compra').html('0.00');
                        $('#txt_precio_total_compra').html('0.00');
                        $('#txt_cod_producto_compra').focus();

                        //Bloquear cantidad
                        $('#txt_cant_producto_compra').attr('disabled','disabled');

                        //Ocultar boton agregar
                        $('#add_product_venta').slideUp();

                    }else{
                        $('#detalle_venta_compra').html('');
                         $('#detalle_totales_compra').html('');
                    }
                    viewProcesar();
                   
                },
                error: function(error){

                }
            });

}

function agregarProductoCompra(codigo){

            var action = 'addProductoDetalleCompra';

            $.ajax({
                url : 'ajax.php',
                type : "POST",
                async : true,
                data : $('#form_del_product').serialize(),
                success: function(response)
                {
                    //console.log(response);
                    if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#detalle_venta_compra').html(info.detalle);
                        $('#detalle_totales_compra').html(info.totales);

                        $('#busquedaProdCompra').val('');
                        $('#busquedaProdCompra').focus();
                        $('.modal').fadeOut();

                     }else{
                        console.log('no data');

                     }
                     viewProcesarCompra();
                },
                error: function(error){
                }
            });

    
    //location.reload();
    //$('.modalBuscarPr').fadeIn();
}

function serchForDetalleProdCompra(busquedaProd,pagina){
        var pagina= pagina;
       $.ajax({
                url : 'action/data_producto_compra.php',
                type : "POST",
                data : {pagina:pagina,busquedaProd:busquedaProd},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#dataProdCompra').html(info.detalle);
                        $('#paginadorProdCompra').html(info.totales);

                     }else{
                        $('#dataProdCompra').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Código</th>'+
                                                        '<th>Descripción</th>'+
                                                        '<th>Existencia</th>'+
                                                        '<th>Costo</th>'+
                                                        '<th>Foto</th>'+
                                                        '<th>Cantidad</th>'+
                                                        '<th>Acción</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                        $('#paginadorProdCompra').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }                  
                
            });
}

//Lista ventas
function listaCompras(busqueda,pagina,cantidad){
         var pagina= pagina;
       $.ajax({
                url : 'action/data_compras.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaCompras').html(info.detalle);
                        $('#paginadorCompras').html(info.totales);

                     }else{
                        $('#listaCompras').html('<table>'+
                                                    '<tr>'+
                                                        '<th>No.</th>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Proveedor</th>'+
                                                        '<th>Usuario</th>'+
                                                        '<th>Estado</th>'+
                                                        '<th class="textright">Total Compra</th>'+
                                                        '<th class="textright">Acciones</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadorCompras').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

 //Registrar cliente
function devolucion(){

    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaVentas('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });   
}

//Modal Form Anular Factura
    function infoAnularRecibo(nofactura){
        /*Act on the event*/
        //e.preventDefault();
        var nofactura = nofactura;
        var action = 'infoFactura';

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,nofactura:nofactura},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);


                   $('.bodyModal').html('<form action="" method="post" name="form_anular_factura" id="form_anular_factura" onsubmit="event.preventDefault(); anularRecibo();">'+
                                            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Anular Recibo</h1><br>'+
                                            '<p>¿Realmente desea anular este recibo?</p>'+
                                            '<p><strong>No. '+info.noventa+'</strong></p>'+
                                            '<p><strong>Monto. C$ '+info.abono+'</strong></p>'+
                                            '<p><strong>Fecha. '+info.fecha+'</strong></p>'+
                                            '<input type="hidden" name="action" value="anularRecibo">'+
                                            '<input type="hidden" name="no_recibo" id="no_recibo" value="'+info.noventa+'" required>'+
                                           
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Anular</button>'+             
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    function anularRecibo(){
            var noventa = $('#no_recibo').val();
            var action = 'anularRecibo';

            $.ajax({
                url : 'ajax.php',
                type: "POST",
                async : true,
                data: {action:action,noventa:noventa},

                success: function(response)
                {
                    //console.log(response);
                    if (response != 'error')
                    {
                        //location.reload();
                    }
                },
                error: function(error){
                }
            });
        
    }

    //Lista de gastos
function listaGastos(busqueda,pagina,cantidad){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_gastos.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaEgresos').html(info.detalle);
                        $('#paginadoEgresos').html(info.totales);

                     }else{
                        $('#listaEgresos').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Descripción</th>'+
                                                        '<th>Cantidad</th>'+
                                                        '<th>Usuario</th>'+
                                                        '<th>Acción</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadoEgresos').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

//Lista de cajas
function listaCajas(busqueda,pagina,cantidad){
    
         var pagina= pagina;
       $.ajax({
                url : 'action/data_caja.php',
                type : "POST",
                data : {pagina:pagina,busqueda:busqueda,cantidad:cantidad},

                success: function(response)
                {
                    //console.log(response);
                  if (response != 'error')
                     {
                        var info = JSON.parse(response);
                        $('#listaCaja').html(info.detalle);
                        $('#paginadoCaja').html(info.totales);

                     }else{
                        $('#listaCaja').html('<table>'+
                                                    '<tr>'+
                                                        '<th>Fecha</th>'+
                                                        '<th>Inicio</th>'+
                                                        '<th>Ventas</th>'+
                                                        '<th>Abonos</th>'+
                                                        '<th>Créditos</th>'+
                                                        '<th>Egresos</th>'+
                                                        '<th>Total efectivo</th>'+
                                                    '</tr>'+
                                                    '<tbody>'+
                                                    '<tr><td colspan="7">No se encontraron concidencias :(</td></tr>'+
                                                    '</tbody>');
                         $('#paginadoCaja').html('');
                        //console.log('no data');

                     }
                    
                },
                error: function(error){

                }
            });
}

    //Registrar Egreso
function nuevoEgreso(){

    var pago = $('#cantEgreso').val();
    var caja = parseInt($('#total_caja').val());

    $('.alertAddProduct').html('');
    if (pago > caja) {
        $('.alertAddProduct').html('<p style="color:red;"> No hay dinero suficiente para realizar el pago.</p>');
        return false;
    }

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                            listaGastos('',1,10);
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

//Modal Form Anular egreso
    function infoAnularEgreso(id){
        /*Act on the event*/
        //e.preventDefault();
        var nofactura = id;
        var action = 'infoEgreso';
       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,nofactura:nofactura},

            success: function(response){
            //console.log(response);            
                if (response != 'error') {
                    var info = JSON.parse(response);


                   $('.bodyModal').html('<form action="" method="post" name="form_anular_factura" id="form_anular_factura" onsubmit="event.preventDefault(); anularEgreso();">'+
                                            '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i> <br> Anular Egreso</h1><br>'+
                                            '<p>¿Realmente desea anular este egreso?</p>'+
                                            '<p><strong>No. '+info.descripcion+'</strong></p>'+
                                            '<p><strong>Monto. C$ '+info.cantidad+'</strong></p>'+
                                            '<input type="hidden" name="action" value="anularEgreso">'+
                                            '<input type="hidden" name="id_gasto" id="id_gasto" value="'+info.id+'" required>'+  
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>'+             
                                        '</form>');
                }
            },

            error: function(error){
                console.log(error);
            }
     
        });

        $('.modal').fadeIn();
        
    }

    //Anular factura
function anularEgreso(){
    var noFactura = $('#id_gasto').val();
    var action = 'anularEgreso';

    $.ajax({
            url : 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,noFactura:noFactura},

            success: function(response)
            {
                //console.log(response);
               if (response == 'error') {
                    $('.alertAddProduct').html('<p style="color:red;">Error al anular elgreso.</p>');
               }else{
                    $('#form_anular_factura .btn_ok').remove();
                    $('.alertAddProduct').html('<p>Egreso anulado correctamente.</p>');
                    listaGastos('',1,10);
               }
            },
            error: function(error){

            }
    });
}


    //abrir caja
function nuevaCaja(){

    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            $('#form_add_product')[0].reset();
                        }else{
                            $('#form_anular_factura .btn_ok').remove();
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        location.reload();
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });    
}

//Cerrar caja
function cerrarCaja(){

    $('.alertAddProduct').html('');

    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_cierre_caja').serialize(),

            success: function(response){ 
            //console.log(response);           
              var info = JSON.parse(response);
                    if (info.cod == '00') {
                            $('.alertAddProduct').html('<p style="color:green;">'+info.msg+'</p>');
                            location.reload();
                        }else{
                             $('.alertAddProduct').html('<p style="color:red;">'+info.msg+'</p>');
                        }
                        
               
            },

            error: function(error)
            {
                console.log(error);
            }
     
        });
    
}

function generarEstado(){
    var fecha_de = $('#desde').val();
    var fecha_a = $('#hasta').val();

    generarReportePDF_estadoR(fecha_de,fecha_a);
    location.reload();
}

function reporteProducto(){
    var codigo = $('#codigoRepProd').val();
    var fecha_de = $('#inicioReporteProd').val();
    var fecha_a = $('#finReporteProd').val();

    generarReporteProducto(fecha_de,fecha_a,codigo);
    //location.reload();
}

    //Modal agregar producto venta
function infoProductAgregar(codigo) {
        /*Act on the event*/
        //e.preventDefault();
        var producto = codigo;
        var action = 'infoProducto';
        var descuento = $('#descuneto_venta').val();

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); agregarProducto();">'+
                                            '<h2 class="nameProducto">'+info.codigo+'</h2>'+
                                            '<p>'+info.descripcion+'</p>'+
                                            '<p>'+info.precio+'</p>'+
                                            '<h1> Ingrese la cantidad</h1>'+
                                            '<input class="textcenter" type="number" name="txt_cant_producto_venta" id="txt_cant_producto_venta" value="1" required>'+
                                            '<input type="hidden" name="txt_existencia_venta" id="txt_existencia_venta" value="'+info.existencia+'" required>'+
                                            '<input type="hidden" step="any" name="txt_precio_venta" id="txt_precio_venta" value="'+info.precio+'" required>'+
                                            '<input type="hidden" name="txt_codigo_venta" id="txt_codigo_venta" value="'+info.codigo+'" required>'+
                                            '<input type="hidden" name="txt_cod_producto_venta" id="txt_cod_producto_venta" value="'+info.codproducto+'" required>'+
                                            '<input type="hidden" name="descuento" id="descuento" value="'+descuento+'" required>'+
                                            '<input type="hidden" name="action" value="addProductoDetalle2" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="fas fa-plus"></i> Agregar</button>'+             
                                        '</form>');
                    $('.modal').fadeIn();
                }
                $('#txt_cant_producto_venta').focus();
                $('#busquedaProd').val('');
            },

            error: function(error){
                console.log(error);
            }          
     
        });      
    }

        //Modal agregar producto venta
function infoProductAgregarEnter(codigo) {
        /*Act on the event*/
        //e.preventDefault();
        var producto = codigo;
        var action = 'infoProductoEnter';
        var descuento = $('#descuneto_venta').val();

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); agregarProducto();">'+
                                            '<h2 class="nameProducto">'+info.codigo+'</h2>'+
                                            '<p>'+info.descripcion+'</p>'+
                                            '<p>'+info.precio+'</p>'+
                                            '<h1> Ingrese la cantidad</h1>'+
                                            '<input class="textcenter" type="number" name="txt_cant_producto_venta" id="txt_cant_producto_venta" value="1" required>'+
                                            '<input type="hidden" name="txt_existencia_venta" id="txt_existencia_venta" value="'+info.existencia+'" required>'+
                                            '<input type="hidden" step="any" name="txt_precio_venta" id="txt_precio_venta" value="'+info.precio+'" required>'+
                                            '<input type="hidden" name="txt_codigo_venta" id="txt_codigo_venta" value="'+info.codigo+'" required>'+
                                            '<input type="hidden" name="txt_cod_producto_venta" id="txt_cod_producto_venta" value="'+info.codproducto+'" required>'+
                                            '<input type="hidden" name="descuento" id="descuento" value="'+descuento+'" required>'+
                                            '<input type="hidden" name="action" value="addProductoDetalle2" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="fas fa-plus"></i> Agregar</button>'+             
                                        '</form>');
                    $('.modal').fadeIn();
                }
                $('#txt_cant_producto_venta').focus();
                $('#busquedaProd').val('');
            },

            error: function(error){
                console.log(error);
            }          
     
        });      
    }


//Modal agregar producto compra
function infoProductAgregarCompra(codigo) {
        /*Act on the event*/
        //e.preventDefault();
        var producto = codigo;
        var action = 'infoProducto';
        //var descuento = $('#descuneto_venta').val();

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); agregarProductoCompra();">'+
                                            '<h2 class="nameProducto">'+info.codigo+'</h2>'+
                                            '<h1>'+info.descripcion+'</h1>'+
                                            '<label class="textcenter">Cantidad</label>'+
                                            '<input class="textcenter" type="number" name="txt_cant_producto_compra" id="txt_cant_producto_compra" value="1" required>'+
                                            '<label class="textcenter">Costo</label>'+
                                            '<input class="textcenter" type="number" step="any" name="txt_precio_compra" id="txt_precio_compra" value="'+info.costo+'" required>'+
                                            '<input type="hidden" name="txt_cod_producto_compra" id="txt_cod_producto_compra" value="'+info.codproducto+'" required>'+
                                            '<input type="hidden" name="action" value="addProductoDetalleCompra" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="fas fa-plus"></i> Agregar</button>'+             
                                        '</form>');
                    $('.modal').fadeIn();
                }

                $('#txt_cant_producto_compra').focus();
                $('#busquedaProdCompra').val('');
            },

            error: function(error){
                console.log(error);
            }          
     
        });      
    }

    //Modal agregar producto compra enter
function infoProductAgregarCompraEnter(codigo) {
        /*Act on the event*/
        //e.preventDefault();
        var producto = codigo;
        var action = 'infoProductoEnter';
        //var descuento = $('#descuneto_venta').val();

       $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},

            success: function(response){            
                if (response != 'error') {
                    var info = JSON.parse(response);

                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); agregarProductoCompra();">'+
                                            '<h2 class="nameProducto">'+info.codigo+'</h2>'+
                                            '<h1>'+info.descripcion+'</h1>'+
                                            '<label class="textcenter">Cantidad</label>'+
                                            '<input class="textcenter" type="number" name="txt_cant_producto_compra" id="txt_cant_producto_compra" value="1" required>'+
                                            '<label class="textcenter">Costo</label>'+
                                            '<input class="textcenter" type="number" step="any" name="txt_precio_compra" id="txt_precio_compra" value="'+info.costo+'" required>'+
                                            '<input type="hidden" name="txt_cod_producto_compra" id="txt_cod_producto_compra" value="'+info.codproducto+'" required>'+
                                            '<input type="hidden" name="action" value="addProductoDetalleCompra" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<a href="#" class="btn_cancel" onclick="coloseModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                            '<button type="submit" class="btn_ok"><i class="fas fa-plus"></i> Agregar</button>'+             
                                        '</form>');
                    $('.modal').fadeIn();
                }

                $('#txt_cant_producto_compra').focus();
                $('#busquedaProdCompra').val('');
            },

            error: function(error){
                console.log(error);
            }          
     
        });      
    }
	var files; // переменная. будет содержать данные файлов

	// заполняем переменную данными, при изменении значения поля file 
	jQuery('input[type=file]').on('change', function(){
		files = this.files;
	});

	// обработка и отправка AJAX запроса при клике на кнопку upload_files
	jQuery('.upload_files').click( function( event ){
       
		event.stopPropagation(); // остановка всех текущих JS событий
		event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

		// ничего не делаем если files пустой
		if( typeof files == 'undefined' ) return;

		// создадим объект данных формы
		var data = new FormData();

		// заполняем объект данных файлами в подходящем для отправки формате
		jQuery.each( files, function( key, value ){
			data.append( key, value );
		});

		// добавим переменную для идентификации запроса
		data.append( 'my_file_upload', 1 );

		// AJAX запрос
		jQuery.ajax({
			url         : '../wp-content/plugins/iq_polls/picture-download.php',
			type        : 'POST', // важно!
			data        : data,
			cache       : false,
			dataType    : 'json',
			// отключаем обработку передаваемых данных, пусть передаются как есть
			processData : false,
			// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
			contentType : false, 
			// функция успешного ответа сервера
			success     : function( respond, status, jqXHR ){

				// ОК - файлы загружены
				if( typeof respond.error === 'undefined' ){
					// выведем пути загруженных файлов в блок '.ajax-reply'
					var files_path = respond.files;
					var html = '';
					jQuery.each( files_path, function( key, val ){
						 html += val +'<br>';
					} )
                    var last_slash=files_path[0].lastIndexOf('\\');
                    var file_name=files_path[0].substr(last_slash+1);	
                    var location=document.location.href;
                    pos_wp_admin=location.lastIndexOf('wp-admin');
                    var path=location.substr(0,pos_wp_admin)+"wp-content/plugins/iq_polls/uploads/";
					//jQuery('.ajax-reply').html( html );
					//jQuery('.ajax-reply').html( path+file_name );
					jQuery('#picture').attr('src',path+file_name);
					jQuery('#picture_file_name').val(file_name);
				}
				// ошибка
				else {
					console.log('ОШИБКА: ' + respond.error );
				}
			},
			// функция ошибки ответа сервера
			error: function( jqXHR, status, errorThrown ){
				console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
			}

		});

	});
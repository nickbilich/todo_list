// Create a "close" button and append it to each list item
$(document).ready(function(){
    $('#content').load('templates/projects_list.php');
    if ($('#hide').prop('disabled') == false) {
	    $('#hide').css('background', 'white');
	    $('#hide').css('color', 'black');
    }
    
    $('#hide').click(function(){
        $('#hide').css('background', 'white');
        $('#hide').css('color', 'black');
        $('#login').css('background', '#428bca');
        $('#login').css('color', 'white');
        $('#registration').css('background', '#428bca');
        $('#registration').css('color', 'white');
        $('#login_register').html('');
    });
    $('#login').click(function(){
        $('#hide').css('background', '#428bca');
        $('#hide').css('color', 'white');
        $('#login').css('background', 'white');
        $('#login').css('color', 'black');
        $('#registration').css('background', '#428bca');
        $('#registration').css('color', 'white');
        $('#login_register').load('templates/login.html');
    });
    $('#registration').click(function(){
        $('#hide').css('background', '#428bca');
        $('#hide').css('color', 'white');
        $('#login').css('background', '#428bca');
        $('#login').css('color', 'white');
        $('#registration').css('background', 'white');
        $('#registration').css('color', 'black');
        $('#login_register').load('templates/registration.html');
    });
});

function add_new_list() {
	$('#block_for_modal').load('templates/modal_project.html');
	$('#send').attr('data-dismiss', '');
    $('#send').unbind('click');
    $('#send').on('click', function(event){
    	$("#form").validate({
	  	      rules:{
	  	             project_name: {
	  		                       required: true,
	  		                       minlength: 5
	  	                       },
	  	      },
	  	      messages:{
	  	         project_name: {
	  		                   required: "Please enter a project name",
	  		                   minlength: "Your project name must consist of at least 5 characters"
	  	                   },
	  	      },
	  	});
	  	if ($("#form").valid()) {
	  		$('#send').attr('data-dismiss', 'modal');
	        $('#preloader').show();
	        var form = $("#form").serialize();
	        ajax('POST', 'add_project', update(), form);
	  	}
    });
}

function remove_project(id){
    $('#preloader' + id).show();
    ajax('POST', 'remove_project', update(), {project_id: id});
}

function edit_project(id){
    $('#block_for_modal').load('templates/modal_project.html');
    $('#send').attr('data-dismiss', '');
    var params = 'project_id=' + id;
    $.ajax({
        type: 'POST',
        url: 'actions/get_edit_project.php',
        data: params,
        success: function(data){
        	data = JSON.parse(data);
        	if (!data['error']){
        		$('form input[name=project_name]').val(data[0]['name']);
        	} else {
        		$('#send').next().trigger('click');
        	}
        }
    });
    $('#send').unbind('click');
    $('#send').on('click', {id: id}, function(event){
    	$("#form").validate({
	  	      rules:{
	  	             project_name: {
	  		                       required: true,
	  		                       minlength: 5
	  	                       },
	  	      },
	  	      messages:{
	  	         project_name: {
	  		                   required: "Please enter a project name",
	  		                   minlength: "Your project name must consist of at least 5 characters"
	  	                   },
	  	      },
	  	});
	  	if ($("#form").valid()) {
	  		$('#send').attr('data-dismiss', 'modal');
	        $('#preloader' + event.data.id).show();
	        var form = $("#form").serialize();
	        form = form + '&project_id=' + event.data.id;
	        ajax('POST', 'edit_project', update(), form);
	  	}
    });
}

function update(project_id){
    setTimeout(function(){
        $('#content').load('templates/projects_list.php');
        $('#preloader' + project_id).hide();
    }, 1000);

}

function add_task(project_id){
	$("#task_form" + project_id).validate({
	      rules:{
	    	  add_task_name: {
		                       required: true,
		                       minlength: 3
	                       },
	      },
	      messages:{
	    	  add_task_name: {
		                   required: "Please enter a task name",
		                   minlength: "Your task name must consist of at least 5 characters"
	                   },
	      },
	});
	if ($("#task_form" + project_id).valid()) {
		var params = 'project_id=' + project_id;
	    $.ajax({
	        type: 'POST',
	        url: 'actions/get_max_task_priority.php',
	        data: params,
	        success: function(data){
	            data = JSON.parse(data);
	            if (!data['error']){
		            $('#preloader' + project_id).show();
		            var form = $("#task_form" + project_id).serialize();
		            form = form + '&project_id=' + project_id + '&priority=' + (Number(data[0]['priority']) + 1);
		            ajax('POST', 'add_task', update(project_id), form);
	            }
	        }
	    });
	}
}

function remove_task(id, project_id){
    $('#preloader' + project_id).show();
    ajax('POST', 'remove_task', update(project_id), {task_id: id});
}

function edit_task(id, project_id){
    $('#block_for_modal').load('templates/modal_task.html');
    $('#send').attr('data-dismiss', '');
    var params = 'task_id=' + id;
    $.ajax({
        type: 'POST',
        url: 'actions/get_edit_task.php',
        data: params,
        success: function(data){
            data = JSON.parse(data);
        	if (!data['error']){
	            var status;
	            if (data[0]['status'] == 1) {
	                status = true;
	            } else {
	                status = false;
	            }
	            $('form input[name=task_name]').val(data[0]['name']);
	            $('form input[name=task_status]').prop('checked', status);
        	} else {
        		$('#send').next().trigger('click');
        	}
        }
    });
    $('#send').unbind('click');
    $('#send').on('click', {id: id, project_id: project_id}, function(event){
    	$("#form").validate({
	  	      rules:{
	  	    	task_name: {
	  		                       required: true,
	  		                       minlength: 3
	  	        },
	  	        deadline: {
	  	        	required : true,
	  	        	date : true,
	  	        },
	  	      },
	  	      messages:{
	  	    	task_name: {
	  		                   required: "Please enter a task name",
	  		                   minlength: "Your task name must consist of at least 5 characters"
	  	                   },
	  	      },
	  	});
	  	if ($("#form").valid()) {
	  		$('#send').attr('data-dismiss', 'modal');
	        $('#preloader' + event.data.project_id).show();
	        var form = $("#form").serialize();
	        form = form + '&task_id=' + event.data.id;
	        ajax('POST', 'edit_task', update(), form);
	  	}
    });
}

function task_up(id, project_id){
    $('#preloader' + project_id).show();
    ajax('POST', 'up_task', update(project_id), {task_id: id, project_id: project_id});
}

function task_down(id, project_id){
    $('#preloader' + project_id).show();
    ajax('POST', 'down_task', update(project_id), {task_id: id, project_id: project_id});
}

function registration(){
	$("#login_registration").validate({
	      rules:{
	             username: {
		                       required: true,
		                       minlength: 3
	                       },
	             password: {
		                       required: true,
		                       minlength: 3
	                       },
	             email:{
		                       required: true,
		                       email: true
	                       },
	      },
	      messages:{
	         username: {
		                   required: "Please enter a username",
		                   minlength: "Your username must consist of at least 3 characters"
	                   },
	         password: {
		                   required: "Please provide a password",
		                   minlength: "Your password must be at least 5 characters long"
	                   },
	         email: "Please enter a valid email address",
	      },
	});
	if ($("#login_registration").valid()) {
		$('#preloader_login_register').show();
	    var form = $("#login_registration").serialize();
	    ajax('POST', 'registration', function(data){
	    	data = JSON.parse(data);
	    	setTimeout(function(){
	            $('#preloader_login_register').hide();
	            if(data.status) {
	        		$("#login_register_success").html(data.text);
	        		$("#login_register_success").show();
	        		$("#login_register_error").hide();
	        		$('#login').trigger('click');
	        	} else {
	        		$("#login_register_error").html(data.text);
	    	    	$("#login_register_error").show();
	    	    	$("#login_register_success").hide();
	        	}
	        }, 1000);
	    }, form);
	}
}

function login(){
	$("#login_registration").validate({
	      rules:{
	             username: {
	                       required: true,
	                       minlength: 3
	                       },
	             password: {
	                       required: true,
	                       minlength: 3
	                       }
	      },
	      messages:{
	         username: {
	                   required: "Please enter a username",
	                   minlength: "Your username must consist of at least 3 characters"
	                   },
	         password: {
	                   required: "Please provide a password",
	                   minlength: "Your password must be at least 5 characters long"
	                   }
	      }
	});
	if ($("#login_registration").valid()) {
		$('#preloader_login_register').show();
		var form = $("#login_registration").serialize();
	    ajax('POST', 'login', function(data){
	    	data = JSON.parse(data);
	    	update();
	    	setTimeout(function(){
	            $('#preloader_login_register').hide();
	            if(data.status) {
	        		$("#login_register_success").html(data.text);
	        		$("#login_register_success").show();
	        		$("#login_register_error").hide();
	        		$("#registration").prop('disabled', true);
	        		$("#hide").prop('disabled', true);
	        		$("#login").html('Logout');
	        		$("#login").attr('onclick', 'logout()');
	        		$("#login_register").html('');
	        	} else {
	        		$("#login_register_error").html(data.text);
	    	    	$("#login_register_error").show();
	    	    	$("#login_register_success").hide();
	        	}
	        }, 1000);
	    }, form);
	}
}

function logout(){
	$('#preloader_login_register').show();
	ajax('POST', 'logout', function(data){
		update();
    	setTimeout(function(){
            $('#preloader_login_register').hide();
        	$("#login_register_success").html(data);
        	$("#login_register_success").show();
        	$("#login_register_error").hide();
        	$("#registration").prop('disabled', false);
        	$("#hide").prop('disabled', false);
        	$("#login").html('Login');
        	$("#login").attr('onclick', '');
        }, 1000);
    });
}
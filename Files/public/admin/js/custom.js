$(function($) {
    "use strict";


    /* ***************************************************
    ==========Bootstrap Notify start==========
    ******************************************************/
    function bootnotify(message, title, type) {
      var content = {};

      content.message = message;
      content.title = title;
      content.icon = 'fa fa-bell';

      $.notify(content,{
        type: type,
        placement: {
          from: 'top',
          align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        allow_dismiss: true,
        delay: 4000,
      });
    }
    /* ***************************************************
    ==========Bootstrap Notify end==========
    ******************************************************/







    /* ***************************************************
    ==========Form Prepopulate After Clicking Edit Button Start==========
    ******************************************************/
    $(".editbtn").on('click', function() {
      let datas = $(this).data();
      delete datas['toggle'];
      console.log(datas);

      for (let x in datas) {
        $("#in"+x).val(datas[x]);
      }
    });
    /* ***************************************************
    ==========Form Prepopulate After Clicking Edit Button End==========
    ******************************************************/




    /* ***************************************************
    ==========Form Update with AJAX Request Start==========
    ******************************************************/
    $("#updateBtn").on('click', function(e) {

      let ajaxEditForm = document.getElementById('ajaxEditForm');
      let fd = new FormData(ajaxEditForm);
      let url = $("#ajaxEditForm").attr('action');
      let method = $("#ajaxEditForm").attr('method');
      // console.log(url);
      // console.log(method);

      $.ajax({
        url: url,
        method: method,
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);

          $(".em").each(function() {
            $(this).html('');
          })

          if (data == "success") {
            location.reload();
          }

          // if error occurs
          else if(typeof data.error != 'undefined') {
            for (let x in data) {
              console.log(x);
              if (x == 'error') {
                continue;
              }
              document.getElementById('eerr'+x).innerHTML = data[x][0];
            }
          }
        }
      });
    });
    /* ***************************************************
    ==========Form Update with AJAX Request End==========
    ******************************************************/



    /* ***************************************************
    ==========Delete Using AJAX Request Start==========
    ******************************************************/
    $('.deletebtn').on('click', function(e) {
      e.preventDefault();
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        buttons:{
          confirm: {
            text : 'Yes, delete it!',
            className : 'btn btn-success'
          },
          cancel: {
            visible: true,
            className: 'btn btn-danger'
          }
        }
      }).then((Delete) => {
        if (Delete) {
          $(this).parent(".deleteform").submit();
        } else {
          swal.close();
        }
      });
    });
    /* ***************************************************
    ==========Delete Using AJAX Request End==========
    ******************************************************/
});
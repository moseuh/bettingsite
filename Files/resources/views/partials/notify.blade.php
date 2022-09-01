
@if (session()->has('success'))
<script>
  var content = {};

  content.message = '{{__(session('success'))}}';
  content.title = 'Success';
  content.icon = 'fa fa-bell';

  $.notify(content,{
    type: 'success',
    placement: {
      from: 'top',
      align: 'right'
    },
    showProgressbar: true,
    time: 1000,
    delay: 4000,
  });
</script>
@endif


@if (session()->has('warning'))
<script>
  var content = {};

  content.message = '{{__(session('warning'))}}';
  content.title = 'Warning!';
  content.icon = 'fa fa-bell';

  $.notify(content,{
    type: 'warning',
    placement: {
      from: 'top',
      align: 'right'
    },
    showProgressbar: true,
    time: 1000,
    delay: 4000,
  });
</script>
@endif


@if (session()->has('danger'))
<script>
  var content = {};

  content.message = '{{__(session('danger'))}}';
  content.title = 'Opps!';
  content.icon = 'fa fa-bell';

  $.notify(content,{
    type: 'danger',
    placement: {
      from: 'top',
      align: 'right'
    },
    showProgressbar: true,
    time: 1000,
    delay: 4000,
  });
</script>
@endif




@if (session()->has('info'))
<script>
  var content = {};

  content.message = '{{__(session('info'))}}';
  content.title = 'Info!';
  content.icon = 'fa fa-bell';

  $.notify(content,{
    type: 'info',
    placement: {
      from: 'top',
      align: 'right'
    },
    showProgressbar: true,
    time: 1000,
    delay: 4000,
  });
</script>
@endif



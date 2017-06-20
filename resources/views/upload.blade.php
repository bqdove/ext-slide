<html>
<head>
    <title>文件上传</title>
</head>
<body>
<h1>文件上传</h1>

<form action="{{url('/api/slide/picture/upload?group_id=388')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="file" name="file" >
    <input type="submit" name="dosubmit" value="上传">
</form>
</body>
</html>

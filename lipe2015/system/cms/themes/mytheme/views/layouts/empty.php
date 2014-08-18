<!DOCTYPE html>
<html>
<head>
	{{ theme:partial name="metadata" }}
</head>
<body>
{{ integration:analytics }}
{{ session:messages success="success-box" notice="notice-box" error="error-box" }}
{{ template:body }}
</body>
</html>
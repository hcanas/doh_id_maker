<!DOCTYPE HTML>
<html>
<head>

</head>
<body>
    <img src="{{ '/storage/cards/front_'.($employee->photo ?? 'placeholder.png') }}" />
    <img src="{{ '/storage/cards/back_'.($employee->photo ?? 'placeholder.png') }}" />
</body>
</html>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('reminders.mail.title')</h2>

		<div>
			@lang('reminders.mail.message')
                        : {{ URL::to('password/reset', array($token)) }}.
		</div>
	</body>
</html>
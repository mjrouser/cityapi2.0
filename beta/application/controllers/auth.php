<?php

class Auth_Controller extends Base_Controller
{
	public function action_login()
	{
		if (!Auth::guest()) {
			return Redirect::to_route('myEvents');
		}

		return View::make('auth.login')
			->with('loginUrl', Helper::facebook()->getLoginUrl(array(
				'scope' => 'user_events',
				'display' => 'popup',
				'redirect_uri' => URL::to_route('auth.facebookConnect'),
			)));
	}

	public function action_facebookConnect()
	{
		assert(Auth::guest());

		$profile = Helper::facebook()->api('/me');

		$user = Model\User::where_facebook_id($profile['id'])->first();

		if (!$user) {
			$user = new Model\User();
			$user->facebook_id = $profile['id'];
			$user->name = $profile['name'];
			$user->save();
		}

		Auth::login($user->id);

		?>
		<html>
			<head>
				<script type="text/javascript">
					if (window.opener) {
						window.opener.location = '<?php echo URL::to_route('login'); ?>';
						window.close();
					} else {
						window.location = '<?php echo URL::to_route('login'); ?>';
					}
				</script>
			</head>	
			<body>
			</body>
		</html>
		<?php
	}

	public function action_logout()
	{
		Auth::logout();

		return Redirect::to_route('home');
	}
}

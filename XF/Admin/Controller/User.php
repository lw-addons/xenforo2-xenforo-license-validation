<?php

namespace LiamW\XenForoLicenseVerification\XF\Admin\Controller;

use XF\Mvc\FormAction;

class User extends XFCP_User
{
	protected function userSaveProcess(\XF\Entity\User $user)
	{
		$formAction = parent::userSaveProcess($user);

		$formAction->apply(function(FormAction $form) use ($user)
		{
			if ($this->filter('liamw_xenforolicenseverification_remove_license', 'bool') === true && $user->XenForoLicense)
			{
				$removeCustomerToken = $this->filter('liamw_xenforolicenseverification_remove_license_customer_token', 'bool');

				$this->repository('LiamW\XenForoLicenseVerification:XenForoLicenseValidation')->expireValidation($user, $removeCustomerToken);
			}
		});

		return $formAction;
	}
}
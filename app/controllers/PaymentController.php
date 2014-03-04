<?php
/**
*    Copyright (C) 2014 Ibrahim Yusuf <ibrahim7usuf@gmail.com>.
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU Affero General Public License, version 3,
*    as published by the Free Software Foundation.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU Affero General Public License for more details.
*
*    You should have received a copy of the GNU Affero General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
*/

class PaymentController extends BaseController
{
	function doPaymnet()
	{
		$amount = 0;
		$return_url = '';

		$cardInput = array(
				'number' => Input::get('cc_number'),
				'firstName' => Input::get('firstName'),
				'lastName' => Input::get('lastName'),
				'expiryMonth' => Input::get('expiryMonth'),
				'expiryYear' => Input::get('expiryYear'),
				'cvv' => Input::get('cvv')
			);

		$card = Omnipay::creditCard($cardInput);

		$response = Omnipay::purchase([
				'amount' => $amount,
				'returnUrl' => $return_url,
				'cancelUrl' => $cancel_url,
				'card' => $cardInput
			]);
	}
}
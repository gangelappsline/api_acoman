<?php

namespace App\Helpers;

use Exception;
use Openpay\Data\Openpay as Openpay;
use Openpay\Data\OpenpayApiError;
use Openpay\Data\OpenpayApiAuthError;
use Openpay\Data\OpenpayApiRequestError;
use Openpay\Data\OpenpayApiConnectionError;
use Openpay\Data\OpenpayApiTransactionError;


class OpenPayHelper
{


    public static function addCustomer($customerData)
    {
            $openpay = Openpay::getInstance(env('OPENPAY_ID'), env('OPENPAY_PRIVATE_KEY'), env('OPENPAY_COUNTRY_CODE'), env('OPENPAY_IP'));
            $customer = $openpay->customers->add($customerData);
            return $customer;
    }

    public static function getCustomer($customerId)
    {
        $openpay = Openpay::getInstance(env('OPENPAY_ID'), env('OPENPAY_PRIVATE_KEY'), env('OPENPAY_COUNTRY_CODE'), env('OPENPAY_IP'));
        $customer = $openpay->customers->get($customerId);
        return $customer;
    }


    public static function addCard($customerID, $cardData)
    {
        try {
            $openpay = Openpay::getInstance(env('OPENPAY_ID'), env('OPENPAY_PRIVATE_KEY'), env('OPENPAY_COUNTRY_CODE'), env('OPENPAY_IP'));

            $customer = $openpay->customers->get($customerID);
            $card = $customer->cards->add($cardData);
            return $card;
            //return view('welcome');
        } catch (OpenpayApiTransactionError $e) {
            return  $e->getMessage();
        } catch (OpenpayApiRequestError $e) {
            return  $e->getMessage();
        } catch (OpenpayApiConnectionError $e) {
            return  $e->getMessage();
        } catch (OpenpayApiAuthError $e) {
            return  $e->getMessage();
        } catch (OpenpayApiError $e) {
            return  $e->getMessage();
        }
    }

    public static function deleteCard($customerID, $cardID)
    {
        $openpay = Openpay::getInstance(env('OPENPAY_ID'), env('OPENPAY_PRIVATE_KEY'), env('OPENPAY_COUNTRY_CODE'), env('OPENPAY_IP'));
        $customer = $openpay->customers->get($customerID);
        $card = $customer->cards->get($cardID);
        $card->delete();
    }

    public static function addPayment($customerID, $cardID, $total, $description, $orderId)
    {
        try {
            $openpay = Openpay::getInstance(env('OPENPAY_ID'), env('OPENPAY_PRIVATE_KEY'), env('OPENPAY_COUNTRY_CODE'), env('OPENPAY_IP'));
            $chargeData = array(
                'source_id' => $cardID,
                'method' => 'card',
                'amount' => $total,
                'description' => $description,
                'device_session_id' => "CS-" . date("YmdHis"),
                'order_id' => $orderId
            );

            $customer = $openpay->customers->get($customerID);
            $charge = $customer->charges->create($chargeData);

            return $charge;
        } catch (OpenpayApiTransactionError $e) {
            return response()->json([
                'error' => [
                    'category' => $e->getCategory(),
                    'error_code' => $e->getErrorCode(),
                    'description' => $e->getMessage(),
                    'http_code' => $e->getHttpCode(),
                    'request_id' => $e->getRequestId()
                ]
            ]);
        } catch (OpenpayApiRequestError $e) {
            return response()->json([
                'error' => [
                    'category' => $e->getCategory(),
                    'error_code' => $e->getErrorCode(),
                    'description' => $e->getMessage(),
                    'http_code' => $e->getHttpCode(),
                    'request_id' => $e->getRequestId()
                ]
            ]);
        } catch (OpenpayApiConnectionError $e) {
            return response()->json([
                'error' => [
                    'category' => $e->getCategory(),
                    'error_code' => $e->getErrorCode(),
                    'description' => $e->getMessage(),
                    'http_code' => $e->getHttpCode(),
                    'request_id' => $e->getRequestId()
                ]
            ]);
        } catch (OpenpayApiAuthError $e) {
            return response()->json([
                'error' => [
                    'category' => $e->getCategory(),
                    'error_code' => $e->getErrorCode(),
                    'description' => $e->getMessage(),
                    'http_code' => $e->getHttpCode(),
                    'request_id' => $e->getRequestId()
                ]
            ]);
        } catch (OpenpayApiError $e) {
            return response()->json([
                'error' => [
                    'category' => $e->getCategory(),
                    'error_code' => $e->getErrorCode(),
                    'description' => $e->getMessage(),
                    'http_code' => $e->getHttpCode(),
                    'request_id' => $e->getRequestId()
                ]
            ]);
        }
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Core\ServiceException;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\Item;
use Illuminate\Support\Facades\Log;
use App\Models\QuickbooksToken;
use Carbon\Carbon;

class QuickBooksController extends Controller
{


    /*
    public function createCustomer()
    {
        $config = config('quickbooks');

        $dataService = DataService::Configure([
            'auth_mode'  => 'oauth2',
            'ClientID'  => $config['client_id'],
            'ClientSecret'  => $config['client_secret'],
            'RedirectURI'  => $config['redirect_uri'],
            //'accessTokenKey'  => $config['access_token'],
            //'refreshTokenKey'  => $config['refresh_token'],
            'accessTokenKey'  => 'eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..oOOyg_00SIDvKOAQELZ7BQ.Dk4HrdJx6prbA20LjFBcnri-a34DnB-HnYVKgjraxZ5UT-9bhNpRQT9_VjEMzEGp2WrEFwGgr0hH8g7EoKA_Sm2snsa5SlGbOGjbQqrOaqf2h22B9dMxlByVl20Mew6MsVKokgZCj7yTkVWoefPKN3RQAFNJeUHjxXJiVJ0qhrBFbQj0_CeUt6eJZXRNopyvhNrvaP4JND_1TeEs_ZG8nPzwkx0OaYP-gttEQwDspxyOGI20i9XqhI4UdNvtZbKeQB2HyR6SSNRG-cS-zT6WlKODjTFJyBk81p-b7xFAzA135uji2-2rUvdp49G33izAEZ7jUuNCjt6xFLHrFlCpeTXW98-Ka0WQOnUlJKMruL0dtGOe_6uVAuN9a5_4_geShvdhS7lw2UxiMl2JCHgAlzOQjrv1sSTRzQLCLhefgltj46araN5fm33lLBKZkRXdrcw93v07mrDSBTDP_-75m5_-Hm-DavqcypL_q0gkX0Jbh6m9RxPJiqzTQXqn_GdojYW6K5UV2qxjySNqpXBZRkVOZhnx6yS491_Q6BPtcT3RHgZavSP1NsrZUPgabsle1IQE9VJlOAw53lSbaZNMJe-976Qj4xepd9F9dTfmj5feRx4IstO8F4y2FERrq-ZgGWUxxhxFtZVETzkXzrXDjDmll42cD6bIN9S-fwRmwx2GjfeAKBNLSa12gK4tAE-SG0ghKnykGYuUd6cgFKfYV3oryWA83xmOoS8I0TEXs4ikSkL0Z_N-_ZEn4dMNzmZUp6NSkVdxw7Pqf-2bk-cdQZ2c02l02DVz0EOmKA2RyM7M-LeY0N0uVYpQ4IImiyrTZr0EAnOpLpdvsn_kfe-XaWpw-FDflrAZlhXZ0RIcMc7t8BIxDIe8Fugc3KyTJ9Ym-Z7LK64vOPgHEfybGowC1A.QnGWKsyZ3SVH9gpQOBqKjA',
            'refreshTokenKey'  => 'AB117281140814KZrgOcBeLU0HFHKG1l1kuspTDHrncJqg2Jcm',
            'QBORealmID'  => $config['realm_id'],
            'baseUrl'  => $config['baseUrl'],
        ]);

        $dataService->setLogLocation(storage_path('logs/quickbooks.log'));
        $dataService->throwExceptionOnError(true);

        $displayname = 'Abdul Moiz';
        $query = "SELECT * FROM Customer WHERE DisplayName = '$displayname'";
        $customer = $dataService->Query($query);

        if (isset($customer) && !empty($customer) && count($customer) > 0) {
            $customer = $customer[0];
            echo "<pre>";print_r($customer);exit;
        } else {
            $customer = Customer::create([
                "GivenName" => $displayname,
                "DisplayName" => $displayname,
                "PrimaryEmailAddr" => [
                    "Address" => 'moiz@test.com'
                ],
                "BillAddr" => [
                    "Line1" => "Rawalpindi",
                    "City" => "Mountain View",
                    "Country" => "PK",
                ],
                "PrimaryPhone" => [
                    "FreeFormNumber" => '+923007734444'
                ]
            ]);

            try {
                $result = $dataService->Add($customer);
                if ($error = $dataService->getLastError()) {
                    Log::error('QuickBooks API Error: ' . $error->getResponseBody());
                    return response()->json(['error' => $error->getResponseBody()], 400);
                }
                Log::info('Successfully added customer: ' . print_r($result, true));
                return response()->json(['success' => $result], 200);
            } catch (ServiceException $ex) {
                Log::error('ServiceException: ' . $ex->getMessage());
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }
    }

    public function quickbook_place_order()
    {
        $config = config('quickbooks');

        $dataService = DataService::Configure([
            'auth_mode'  => 'oauth2',
            'ClientID'  => $config['client_id'],
            'ClientSecret'  => $config['client_secret'],
            'RedirectURI'  => $config['redirect_uri'],
            'accessTokenKey'  => $config['access_token'],
            'refreshTokenKey'  => $config['refresh_token'],
            //'accessTokenKey'  => 'eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..oOOyg_00SIDvKOAQELZ7BQ.Dk4HrdJx6prbA20LjFBcnri-a34DnB-HnYVKgjraxZ5UT-9bhNpRQT9_VjEMzEGp2WrEFwGgr0hH8g7EoKA_Sm2snsa5SlGbOGjbQqrOaqf2h22B9dMxlByVl20Mew6MsVKokgZCj7yTkVWoefPKN3RQAFNJeUHjxXJiVJ0qhrBFbQj0_CeUt6eJZXRNopyvhNrvaP4JND_1TeEs_ZG8nPzwkx0OaYP-gttEQwDspxyOGI20i9XqhI4UdNvtZbKeQB2HyR6SSNRG-cS-zT6WlKODjTFJyBk81p-b7xFAzA135uji2-2rUvdp49G33izAEZ7jUuNCjt6xFLHrFlCpeTXW98-Ka0WQOnUlJKMruL0dtGOe_6uVAuN9a5_4_geShvdhS7lw2UxiMl2JCHgAlzOQjrv1sSTRzQLCLhefgltj46araN5fm33lLBKZkRXdrcw93v07mrDSBTDP_-75m5_-Hm-DavqcypL_q0gkX0Jbh6m9RxPJiqzTQXqn_GdojYW6K5UV2qxjySNqpXBZRkVOZhnx6yS491_Q6BPtcT3RHgZavSP1NsrZUPgabsle1IQE9VJlOAw53lSbaZNMJe-976Qj4xepd9F9dTfmj5feRx4IstO8F4y2FERrq-ZgGWUxxhxFtZVETzkXzrXDjDmll42cD6bIN9S-fwRmwx2GjfeAKBNLSa12gK4tAE-SG0ghKnykGYuUd6cgFKfYV3oryWA83xmOoS8I0TEXs4ikSkL0Z_N-_ZEn4dMNzmZUp6NSkVdxw7Pqf-2bk-cdQZ2c02l02DVz0EOmKA2RyM7M-LeY0N0uVYpQ4IImiyrTZr0EAnOpLpdvsn_kfe-XaWpw-FDflrAZlhXZ0RIcMc7t8BIxDIe8Fugc3KyTJ9Ym-Z7LK64vOPgHEfybGowC1A.QnGWKsyZ3SVH9gpQOBqKjA',
            //'refreshTokenKey'  => 'AB117281140814KZrgOcBeLU0HFHKG1l1kuspTDHrncJqg2Jcm',
            'QBORealmID'  => $config['realm_id'],
            'baseUrl'  => $config['baseUrl'],
        ]);

        $dataService->setLogLocation(storage_path('logs/quickbooks.log'));
        $dataService->throwExceptionOnError(true);
        //Add a new Invoice
        $theResourceObj = Invoice::create([
            "Line" => [
                [
                    "Amount" => 50.00,
                    "DetailType" => "SalesItemLineDetail",
                    "SalesItemLineDetail" => [
                        "ItemRef" => [
                            "value" => 2,
                            "name" => "xyz"
                        ]
                    ]
                ]
            ],
            "CustomerRef"=> [
                "value"=> 60
            ],
            "BillEmail" => [
                "Address" => "Familiystore@intuit.com"
            ],
            "BillEmailCc" => [
                "Address" => "a@intuit.com"
            ],
            "BillEmailBcc" => [
                "Address" => "v@intuit.com"
            ]
        ]);
        $resultingObj = $dataService->Add($theResourceObj);

        $theResourceObj = Item::create([
            "Name" => "Test Product added from api a",
            "UnitPrice" => 470,
            "IncomeAccountRef" => [
                "value" => "79",
                "name" => "Sales of Product Income"
            ],
            "ExpenseAccountRef" => [
                "value" => "80",
                "name" => "Cost of Goods Sold"
            ],
            "AssetAccountRef" => [
                "value" => "81",
                "name" => "Inventory Asset"
            ],
            'Type' => 'NonInventory',
            'Sku' => 'test-344',
            "QtyOnHand" => 500,
            "InvStartDate" => "2015-01-01"
        ]);

        $resultingObj = $dataService->Add($theResourceObj);


        echo "<pre>";print_r($resultingObj);exit;
        $error = $dataService->getLastError();
        if ($error) {
            echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
            echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
            echo "The Response message is: " . $error->getResponseBody() . "\n";
        }
        else {
            echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
            $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
            echo $xmlBody . "\n";
        }

    }

    public function quickbook_place_order2()
    {
        $config = config('quickbooks');

        $dataService = DataService::Configure([
            'auth_mode'  => 'oauth2',
            'ClientID'  => $config['client_id'],
            'ClientSecret'  => $config['client_secret'],
            'RedirectURI'  => $config['redirect_uri'],
            'accessTokenKey'  => $config['access_token'],
            'refreshTokenKey'  => $config['refresh_token'],
            //'accessTokenKey'  => 'eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..oOOyg_00SIDvKOAQELZ7BQ.Dk4HrdJx6prbA20LjFBcnri-a34DnB-HnYVKgjraxZ5UT-9bhNpRQT9_VjEMzEGp2WrEFwGgr0hH8g7EoKA_Sm2snsa5SlGbOGjbQqrOaqf2h22B9dMxlByVl20Mew6MsVKokgZCj7yTkVWoefPKN3RQAFNJeUHjxXJiVJ0qhrBFbQj0_CeUt6eJZXRNopyvhNrvaP4JND_1TeEs_ZG8nPzwkx0OaYP-gttEQwDspxyOGI20i9XqhI4UdNvtZbKeQB2HyR6SSNRG-cS-zT6WlKODjTFJyBk81p-b7xFAzA135uji2-2rUvdp49G33izAEZ7jUuNCjt6xFLHrFlCpeTXW98-Ka0WQOnUlJKMruL0dtGOe_6uVAuN9a5_4_geShvdhS7lw2UxiMl2JCHgAlzOQjrv1sSTRzQLCLhefgltj46araN5fm33lLBKZkRXdrcw93v07mrDSBTDP_-75m5_-Hm-DavqcypL_q0gkX0Jbh6m9RxPJiqzTQXqn_GdojYW6K5UV2qxjySNqpXBZRkVOZhnx6yS491_Q6BPtcT3RHgZavSP1NsrZUPgabsle1IQE9VJlOAw53lSbaZNMJe-976Qj4xepd9F9dTfmj5feRx4IstO8F4y2FERrq-ZgGWUxxhxFtZVETzkXzrXDjDmll42cD6bIN9S-fwRmwx2GjfeAKBNLSa12gK4tAE-SG0ghKnykGYuUd6cgFKfYV3oryWA83xmOoS8I0TEXs4ikSkL0Z_N-_ZEn4dMNzmZUp6NSkVdxw7Pqf-2bk-cdQZ2c02l02DVz0EOmKA2RyM7M-LeY0N0uVYpQ4IImiyrTZr0EAnOpLpdvsn_kfe-XaWpw-FDflrAZlhXZ0RIcMc7t8BIxDIe8Fugc3KyTJ9Ym-Z7LK64vOPgHEfybGowC1A.QnGWKsyZ3SVH9gpQOBqKjA',
            //'refreshTokenKey'  => 'AB117281140814KZrgOcBeLU0HFHKG1l1kuspTDHrncJqg2Jcm',
            'QBORealmID'  => $config['realm_id'],
            'baseUrl'  => $config['baseUrl'],
        ]);

        //$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        //$accessToken = $OAuth2LoginHelper->refreshToken();
       // print_r($accessToken);exit;
        $dataService->setLogLocation(storage_path('logs/quickbooks.log'));
        $dataService->throwExceptionOnError(true);

        $order = [
            'customer_id' => '60',
            'items' => [
                [
                    'name' => 'Trays A SKU-3',
                    'sku' => 'SKU-3',
                    'price' => 2.00,
                    'quantity' => 4
                ],
                [
                    'name' => 'Trays B SKU-2',
                    'sku' => 'SKU-2',
                    'price' => 4.00,
                    'quantity' => 5
                ]
            ]
        ];


        $lineItems = [];

        foreach ($order['items'] as $item) {
            $itemId = $this->findOrCreateNonInventoryItem($item['sku'], $item['name'], $item['price']);

            $lineItems[] = [
                "DetailType" => "SalesItemLineDetail",
                "Amount" => $item['price'] * $item['quantity'],
                "SalesItemLineDetail" => [
                    "ItemRef" => [
                        "value" => $itemId
                    ],
                    "Qty" => $item['quantity']
                ]
            ];
        }

        $invoiceData = Invoice::create([
            "Line" => $lineItems,
            "CustomerRef" => [
                "value" => $order['customer_id']
            ]
        ]);

        $invoice = $dataService->Add($invoiceData);
        echo "<pre>";print_r($invoice);exit;
    }

    public function findOrCreateNonInventoryItem($sku, $name, $price)
    {
        $config = config('quickbooks');
        $dataService = DataService::Configure([
            'auth_mode'  => 'oauth2',
            'ClientID'  => $config['client_id'],
            'ClientSecret'  => $config['client_secret'],
            'RedirectURI'  => $config['redirect_uri'],
            'accessTokenKey'  => $config['access_token'],
            'refreshTokenKey'  => $config['refresh_token'],
            //'accessTokenKey'  => 'eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..oOOyg_00SIDvKOAQELZ7BQ.Dk4HrdJx6prbA20LjFBcnri-a34DnB-HnYVKgjraxZ5UT-9bhNpRQT9_VjEMzEGp2WrEFwGgr0hH8g7EoKA_Sm2snsa5SlGbOGjbQqrOaqf2h22B9dMxlByVl20Mew6MsVKokgZCj7yTkVWoefPKN3RQAFNJeUHjxXJiVJ0qhrBFbQj0_CeUt6eJZXRNopyvhNrvaP4JND_1TeEs_ZG8nPzwkx0OaYP-gttEQwDspxyOGI20i9XqhI4UdNvtZbKeQB2HyR6SSNRG-cS-zT6WlKODjTFJyBk81p-b7xFAzA135uji2-2rUvdp49G33izAEZ7jUuNCjt6xFLHrFlCpeTXW98-Ka0WQOnUlJKMruL0dtGOe_6uVAuN9a5_4_geShvdhS7lw2UxiMl2JCHgAlzOQjrv1sSTRzQLCLhefgltj46araN5fm33lLBKZkRXdrcw93v07mrDSBTDP_-75m5_-Hm-DavqcypL_q0gkX0Jbh6m9RxPJiqzTQXqn_GdojYW6K5UV2qxjySNqpXBZRkVOZhnx6yS491_Q6BPtcT3RHgZavSP1NsrZUPgabsle1IQE9VJlOAw53lSbaZNMJe-976Qj4xepd9F9dTfmj5feRx4IstO8F4y2FERrq-ZgGWUxxhxFtZVETzkXzrXDjDmll42cD6bIN9S-fwRmwx2GjfeAKBNLSa12gK4tAE-SG0ghKnykGYuUd6cgFKfYV3oryWA83xmOoS8I0TEXs4ikSkL0Z_N-_ZEn4dMNzmZUp6NSkVdxw7Pqf-2bk-cdQZ2c02l02DVz0EOmKA2RyM7M-LeY0N0uVYpQ4IImiyrTZr0EAnOpLpdvsn_kfe-XaWpw-FDflrAZlhXZ0RIcMc7t8BIxDIe8Fugc3KyTJ9Ym-Z7LK64vOPgHEfybGowC1A.QnGWKsyZ3SVH9gpQOBqKjA',
            //'refreshTokenKey'  => 'AB117281140814KZrgOcBeLU0HFHKG1l1kuspTDHrncJqg2Jcm',
            'QBORealmID'  => $config['realm_id'],
            'baseUrl'  => $config['baseUrl'],
        ]);

        $items = $dataService->Query("SELECT * FROM Item WHERE Sku='$sku'");
        if (!empty($items)) {
            return $items[0]->Id;
        } else {
            $itemData = Item::create([
                "Name" => $name,
                "Sku" => $sku,
                "Type" => "NonInventory",
                "IncomeAccountRef" => [
                    "value" => "1" // Adjust this account ID based on your QuickBooks setup
                ],
                "UnitPrice" => $price,
                "ExpenseAccountRef" => [
                    "value" => "2" // Adjust this account ID based on your QuickBooks setup
                ]
            ]);

            $item = $dataService->Add($itemData);
            return $item->Id;
        }
    }
    */

    public function connect()
    {
        $dataService = $this->getDataService();
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $code = $request->get('code');
        $realmId = $request->get('realmId');

        if (!$code || !$realmId) {
            return redirect()->route('home')->with('error', 'Authorization code or realm ID is missing.');
        }

        $dataService = $this->getDataService();
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);

        // Extract token data
        $token = $accessToken->getAccessToken();
        $refreshToken = $accessToken->getRefreshToken();
        $tokenExpiry = $accessToken->getAccessTokenExpiresAt(); // Use this method
        echo "Token : ". $token;
        echo "<hr>";
        echo "RefreshToken : ". $refreshToken;
        echo "<hr>";
        echo "TokenExpiry : ". $tokenExpiry;
        echo "<hr>";
        QuickbooksToken::updateOrCreate(
            ['id' => 1],
            [
                'access_token' => $token,
                'refresh_token' => $refreshToken,
                'realm_id' => $realmId,
                'token_expiry' => Carbon::parse($tokenExpiry)
            ]
        );

        $dataService->updateOAuth2Token($accessToken);
       // echo "Done successfully";
    }

    public function createCustomer()
    {
        $dataService = $this->getDataServiceWithTokens();

        if (!$dataService) {
            return redirect()->route('quickbooks.connect');
        }

        $displayname = 'Abdul Moiz';
        $query = "SELECT * FROM Customer WHERE DisplayName = '$displayname'";
        $customer = $dataService->Query($query);

        if (isset($customer) && !empty($customer) && count($customer) > 0) {
            $customer = $customer[0];
            echo "<pre>";
            print_r($customer);
            exit;
        } else {
            $customer = Customer::create([
                "GivenName" => $displayname,
                "DisplayName" => $displayname,
                "PrimaryEmailAddr" => [
                    "Address" => 'moiz@test.com'
                ],
                "BillAddr" => [
                    "Line1" => "Rawalpindi",
                    "City" => "Mountain View",
                    "Country" => "PK",
                ],
                "PrimaryPhone" => [
                    "FreeFormNumber" => '+923007734444'
                ]
            ]);

            try {
                $result = $dataService->Add($customer);
                if ($error = $dataService->getLastError()) {
                    Log::error('QuickBooks API Error: ' . $error->getResponseBody());
                    return response()->json(['error' => $error->getResponseBody()], 400);
                }
                Log::info('Successfully added customer: ' . print_r($result, true));
                return response()->json(['success' => $result], 200);
            } catch (ServiceException $ex) {
                Log::error('ServiceException: ' . $ex->getMessage());
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }
    }

    private function getDataService()
    {
        $config = config('quickbooks');

        return DataService::Configure([
            'auth_mode' => 'oauth2',
            'ClientID' => $config['client_id'],
            'ClientSecret' => $config['client_secret'],
            'RedirectURI' => $config['redirect_uri'],
            'scope' => 'com.intuit.quickbooks.accounting',
            'baseUrl'  => $config['baseUrl'],
        ]);
    }

    private function getDataServiceWithTokens()
    {
        $dataService = $this->getDataService();

        $token = QuickbooksToken::first();

        if ($token) {
            if (Carbon::now()->greaterThan($token->token_expiry)) {
                // Token has expired, refresh it
                $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
                $newAccessToken = $OAuth2LoginHelper->refreshAccessTokenWithRefreshToken($token->refresh_token);

                $token->update([
                    'access_token' => $newAccessToken->getAccessToken(),
                    'refresh_token' => $newAccessToken->getRefreshToken(),
                    'token_expiry' => Carbon::now()->addSeconds($newAccessToken->getAccessTokenExpiresAt())
                ]);

                // Update the DataService with the new tokens
                $dataService->updateOAuth2Token($newAccessToken);
            } else {
                // Token is still valid, update DataService with existing tokens
                $accessToken = new \QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2AccessToken(
                    $token->access_token,
                    $token->refresh_token,
                    null, // Expires in (optional)
                    $token->token_expiry->getTimestamp() // Expires at (UNIX timestamp)
                );

                $dataService->updateOAuth2Token($accessToken);
            }

            return $dataService;
        }

        return null;
    }



}

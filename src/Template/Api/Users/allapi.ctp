<style>
    li{
        margin-bottom: 15px;
    }
</style>
<b style="text-align:center;width: 100%;float: left;">Base Url:  http://simerjit.gangtask.com/supperout/api/</b>
<ol>
    <li>
        <b>Add User</b> <br/>
        @url: users/add.json <br/>
        @method: POST <br/>
        @params: firstname,lastname,username,email, password, facebook_token, twitter_token, instagram_token, google_token, status (true/false based on you want to verify email or not),current_language <br/>
    </li>
    <li>
        <b>Verify Email Address Using OTP</b><br/>
        @url: users/verifyOtp.json <br/>
        @method: POST <br/>
        @params: user_id, otp <br/>
    </li>
    <li>
        <b>Login User</b> <br/>
        @url: users/login.json <br/>
        @method: POST <br/>
        @params: username, password <br/>
    </li>
    <li>
        <b>View User Detail</b> <br/>
        @url: users/view/$id.json <br/>
        @method: GET <br/>
        @params: $id <br/>
    </li>
    <li>
        <b>Edit User </b> <br/>
        @url: users/edit/$id.json <br/>
        @method: POST <br/>
        @params: firstname, lastname, address, nationality, description <br/>
    </li>
    <li>
        <b>Change Password </b> <br/>
        @url: users/changePassword.json <br/>
        @method: POST <br/>
        @params: id,old_password, new_password, confirm_password <br/>
    </li>
    <li>
        <b>Forgot Password </b> <br/>
        @url: users/forgotPassword.json <br/>
        @method: POST <br/>
        @params: email, current_language <br/>
    </li>
    <li>
        <b>Search Restaurant By Name/ Cuisine Name</b> <br/>
        @url: restaurants/searchByName.json <br/>
        @method: POST <br/>
        @params: name <br/>
    </li>
    <li>
        <b>Get Categories & Dishes of a Restaurant</b> <br/>
        @url: menus/getCategories/$restaurant_id.json <br/>
        @method: GET <br/>
    </li>
    <li>
        <b>Add item to Cart</b> <br/>
        @url: carts/add.json <br/>
        @param user_id,restaurant_id,product_id,quantity,comment,refill<br/>
        @method: POST <br/>
    </li>
    <li>
        <b>Get Cart Items</b> <br/>
        @url: carts/view/$user_id.json <br/>
        @param user_id<br/>
        @method: GET <br/>
    </li>
    <li>
        <b>Remove Item from Cart</b> <br/>
        @url: carts/delete/$cart_id.json <br/>
        @param cart_id<br/>
        @method: DELETE <br/>
    </li>
    <li>
        <b>Increase/Decrease Quantity of Cart Item</b> <br/>
        @url: carts/edit/$cart_id.json <br/>
        @param cart_id, quantity<br/>
        @method: PUT/POST <br/>
    </li>
    <li>
        <b>Add a Card</b> <br/>
        @url: cards/add.json <br/>
        @param: user_id,cardnumber,expiry_date,cardholder_name<br/>
        @method: POST <br/>
    </li>
    <li>
        <b>Delete a Card</b> <br/>
        @url: cards/delete/$card_id.json <br/>
        @param: card_id<br/>
        @method: DELETE <br/>
    </li>
    <li>
        <b>View my Cards</b> <br/>
        @url: cards/view/$user_id.json <br/>
        @param: user_id<br/>
        @method: GET <br/>
    </li>
    <li>
        <b>Upload Profile Image</b> <br/>
        @url: users/uploadImage/$user_id.json <br/>
        @param: image<br/>
        @method: POST <br/>
    </li>
    <li>
        <b>Terms and Conditions</b> <br/>
        @url: pages/page/terms_and_conditions.json <br/>
        @method: GET <br/>
    </li>
    <li>
        <b>List all Restaurants</b>(Not based on location yet) <br/>
        @url: restaurants/index.json <br/>
        @method: POST <br/>
        @param: latitude, longitude <br/>
    </li>
    <li>
        <b>List Particular Restaurant</b> <br/>
        @url: restaurants/view/$restaurant_id.json <br/>
        @method: GET <br/>
    </li>
    <li>
        <b>Web page to fetch all barcodes</b> <br/>
        @url: http://simerjit.gangtask.com/supperout/api/users/barcodes <br/>
    </li>
    <li>
        <b>Check Username/email exist</b> <br/>
        @url: users/userExist.json <br/>
        @param: email (Email can ontain email or username), social(twitter,facebook, instagram, google), token<br/>
        @method: POST <br/>
    </li>
    <li>
        <b>Scan/Book a Table</b> <br/>
        @url: bookTables/add.json <br/>
        @param: user_id, bar_code<br/>
        @method: POST <br/>
    </li>
    <li>
        <b>Suggestion to Admin</b> <br/>
        @url: suggestions/add.json <br/>
        @param: user_id, restaurant_name, location,content, current_language<br/>
        @method: POST <br/>
    </li>
    <li>
        <b>Place an order</b> <br/>
        @url: orders/add.json <br/>
        @param: user_id, table_id, gratuity<br/>
        @method: POST <br/>
    </li>
    <li>
        <b>Get order detail</b> <br/>
        @url: orders/view/$order_id.json <br/>
        @method: GET <br/>
    </li>
    <li>
        <b>Get my orders</b> <br/>
        @url: orders/viewbyuser/$user_id.json <br/>
        @method: GET <br/>
    </li>
    <li>
        <b>Update Bill by Gratuity and payment status</b> <br/>
        @url: orders/edit/$order_id.json <br/>
        @method: POST <br/>
        @param: In case of cash: gratuity,current_language, payment_method=cash<br/>
        @param: In case of card: gratuity,current_language, payment_method=card, card_id, payment_token<br/>
    </li>
    <li>
        <b>Request for refill/help</b> <br/>
        @url: helpRequests/add.json<br/>
        @method: POST <br/>
        @param: user_id,restaurant_id,order_id,waiter_id,table_id,type = refill/help<br/>
    </li>
    <li>
        <b>Filter Restaurant</b> <br/>
        @url: restaurants/filter.json<br/>
        @method: POST <br/>
        @param: name, cuisine_id, min_price, max_price, distance, latitude(Mandatory), longitude(Mandatory),amenities(should be an array)<br/>
    </li>
    <li>
        <b>Feedback</b> <br/>
        @url: ratings/add.json<br/>
        @method: POST <br/>
        @param: user_id,restaurant_id,order_id,service,quality,ambiance, comment,reason<br/>
    </li>
    <li>
        <b>List All Cuisines</b> <br/>
        @url: cuisines/index.json<br/>
        @method: GET <br/>
    </li>
    <li>
        <b>Save Device Token</b> <br/>
        @url: devices/add.json<br/>
        @method: POST <br/>
        @param: user_id,device_token,device_type (android/ios)<br/>
    </li>
    <li>
        <b>Add more items to order</b> <br/>
        @url: orders/addmore/$order_id.json<br/>
        @method: POST <br/>
        @param: order_id, user_id, restaurant_id<br/>
    </li>
    <li>
        <b>List All Amenities</b> <br/>
        @url: amenities/index.json<br/>
        @method: GET <br/>
    </li>
    <li>
        <b>List All Rewards</b> <br/>
        @url: orders/myrewards/$user_id.json<br/>
        @method: GET <br/>
    </li>
    
</ol>


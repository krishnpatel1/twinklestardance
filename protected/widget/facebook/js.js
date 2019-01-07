/**
 * Created with JetBrains PhpStorm.
 * User: andy
 * Date: 11/22/13
 * Time: 4:25 PM
 * To change this template use File | Settings | File Templates.
 */
window.fbAsyncInit = function() {
    FB.init({   appId: '{$this->appId}',
        status: {$this->status},
        cookie: {$this->cookie},
        xfbml: {$this->xfbml},
        oauth: {$this->oauth}
    });

    function updateButton(response) {

        var b = document.getElementById("{$this->fbLoginButtonId}");
        if (b){
        b.onclick = function(){
            FB.login(function(response) {
                if(response.authResponse) {
                    FB.api('/me', function(user) {
                        $.ajax({
                            type : 'get',
                            url  : '{$this->facebookLoginUrl}' +'?type=' + getParam(),
                            data : ( {
                                name     :   user.first_name,
                                surname  :   user.last_name,
                                username :   user.username,
                                id       :   user.userID,
                                email    :   user.email,
                                picture  :   user.picture,
                                session  :   "{$this->userSession}"
                            } ),
                            dataType : 'json',
                            success : function( data ){
                                if( data.error == 0){
                                    parent.jQuery.colorbox.close();
                                    top.location.href  = data.redirect;
                                }else{
                                    alert( data.error );
                                    FB.logout();
                                }
                            }
                        });

                    });
                }
            }, {scope: '{$this->facebookPermissions}'});
        }
    }
    }

    FB.getLoginStatus(updateButton);
    FB.Event.subscribe('auth.statusChange', updateButton);

    var c = document.getElementById("{$this->logoutButtonId}");
    if(c){
        c.onclick = function(){
            FB.logout();
        }
    }
};

(function(d){var e,id = "fb-root";if( d.getElementById(id) == null ){e = d.createElement("div");e.id=id;d.body.appendChild(e);}}(document));
(function(d){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];if (d.getElementById(id)) {return;} js = d.createElement('script'); js.id = id; js.async = true; js.src = "//connect.facebook.net/en_US/all.js"; ref.parentNode.insertBefore(js, ref); }(document));
function getParam()
{
    var rates = document.getElementsByName('Users[role_id]');
    var rate_value;
    for(var i = 0; i < rates.length; i++){
        if(rates[i].checked){
            rate_value = rates[i].value;
        }
    }
    return rate_value;
}
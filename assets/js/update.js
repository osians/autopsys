/**
 * Show loading animation
 * return void
 */
function showLoading()
{
    $(".loading").html('<br><img alt="loading" src="assets/image/loader.gif" width="16" height="16" />');
}

/**
 * Hide loading animation
 * return void
 */
function hideLoading()
{
    $(".loading").html("");
}

/**
 * show message
 * @param {string} message
 * @return void
 */
function showMessage(message)
{
    $(".loading").html('<br>' + message);
}

/**
 * Check if system version needs update
 *
 * @param {function} callback
 * @return void
 */
function whenVersionsDifferent(callback)
{
    $.ajax({
        type: 'POST',
        url: "checkVersion.php",
        dataType: "json",
        beforeSend: function () {
            showLoading();
        },
        success: function (data) {
            hideLoading();

            // same version
            if (data.version === 0) {
                // user has the latest version already installed
                $(".check-update").html("");
                showMessage("You already have the latest version.");
                return;
            }

            callback(data.version);
        },
        error: function() {
            showMessage('There was an error checking your latest version.');
        }
    });
}

/**
 * Exec this function when the versions are different
 */
function onDifferentVersions(newVersion)
{
    let uInfo = "uid=1&vnum=" + newVersion;

    $.ajax({
        type: "POST",
        url: "updateVersion.php",
        data: uInfo,
        dataType: "json",
        beforeSend: function() {
            showLoading();
        },
        success: function (data) {
            // check for version verification
            if(data.copy != 0){
                if(data.unzip == 1){
                    // clear loading information
                    $(".version_check").html("");
                    // successful update
                    $(".loading").html("Successful Update!");
                }else{
                    // error during update/unzip
                    showMessage('Sorry, there was an error with the update.');
                }
            }
        },
        error: function() {
            showMessage('There was an error updating your files.');
        }
    });
}


/**
 * check users files and update with most recent version
 */
function versionCheckButtonInit()
{
    $('.check-update').on('click',function(e) {
        whenVersionsDifferent(onDifferentVersions);
    });
}

// on Ready
$(document).ready(function(){
    versionCheckButtonInit();
});

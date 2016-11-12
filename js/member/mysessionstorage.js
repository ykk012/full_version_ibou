function expiration_check(storageKey) {
 
    var hasStorage = ("sessionStorage" in window && window.sessionStorage),
        now, expiration, data = false;
 
    try {
        if (hasStorage) {
            data = sessionStorage.getItem(storageKey);
            if (data) {
                // extract saved object from JSON encoded string
                data = JSON.parse(data);
 
                // calculate expiration time for content,
                // to force periodic refresh after 30 minutes
                now = new Date();
                expiration = new Date(data.timestamp);
                expiration.setMinutes(expiration.getMinutes()+30);
 
                // ditch the content if too old
                if (now.getTime() > expiration.getTime()) {
                    data = false;
                    sessionStorage.removeItem(storageKey);
                }
            }
        }
    }
    catch (e) {
        data = false;
    }
 
}
function my_sessionStorage(storageKey,content){
    sessionStorage.setItem(
        storageKey,
        JSON.stringify({
            timestamp: new Date(),
            content : content
        })
    );
}
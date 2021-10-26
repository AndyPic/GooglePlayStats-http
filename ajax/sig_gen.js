/**
 * messages must be array of key-value pair strings eg. [0] = stuff=1, [1] = otherstuff=2
 */
function generateSignature(messages = Array(), apiKey) {
    var innerArray;
    var outerArray = new Array();
    var object = new Object();

    // Sort a-z
    for (var loop = 0; loop < messages.length; loop++) {
        innerArray = messages[loop].split("=");

        object = {
            key: innerArray[0],
            value: innerArray[1]
        };

        outerArray.push(object);
    }
    // Sort alphabetically by key with comparator
    outerArray.sort(
        function (a, b) {
            if (a.key < b.key) {
                return -1;
            } else if (a.key > b.key) {
                return 1;
            } else {
                return 0;
            }
        });

    // Concatonate
    var message = "";
    for (loop = 0; loop < outerArray.length; loop++) {
        message += outerArray[loop].key;
        message += outerArray[loop].value;
    }

    // Hash
    var signature = CryptoJS.HmacMD5(message, apiKey);
    signature = CryptoJS.enc.Base64.stringify(signature);

    // URL encode to send
    signature = encodeURIComponent(signature);

    return signature;
}
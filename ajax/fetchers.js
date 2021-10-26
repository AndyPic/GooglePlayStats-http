var goGet = async (url, inputs) => {
    // Build endpoint
    endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/";
    endpoint += url;

    if (typeof inputs == "object") {
        for (loop = 0; loop < inputs.length; loop++) {
            if (loop == 0) {
                endpoint += "?"
            }
            endpoint += inputs[loop]
            endpoint += "&"
        }
    } else {
        // String
        endpoint += "?" + inputs
    }

    // Fetch json response
    const response = await fetch(endpoint, {
        method: "GET",
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json'
        },
    })
    // Get http status num
    const { status } = response;
    // Check if ok (200-299 code)
    if (!response.ok) {
        throw new Error("HTTP error " + status);
    }
    //return the json parsed response
    const data = (await response.json())
    return data;
}

var goPut = async (url, inputs) => {
    // Build endpoint
    endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/";
    endpoint += url;

    var sentData = new URLSearchParams();

    for (var key in inputs) {
        sentData.append(key, inputs[key])
    }

    // Fetch json response
    const response = await fetch(endpoint, {
        method: "PUT",
        body: sentData
    })
    // Get http status num
    const { status } = response;
    // Check if ok (200-299 code)
    if (!response.ok) {
        throw new Error("HTTP error " + status);
    }
    //return the json parsed response
    const data = (await response.json())
    return data;
}

var goPost = async (url, inputs) => {
    // Build endpoint
    endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/";
    endpoint += url;

    var sentData = new URLSearchParams();

    for (var key in inputs) {
        sentData.append(key, inputs[key])
    }

    // Fetch json response
    const response = await fetch(endpoint, {
        method: "POST",
        body: sentData
    })
    // Get http status num
    const { status } = response;
    // Check if ok (200-299 code)
    if (!response.ok) {
        throw new Error("HTTP error " + status);
    }
    //return the json parsed response
    const data = (await response.json())
    return data;
}

var goDelete = async (url, inputs) => {
    // Build endpoint
    endpoint = "http://apickard01.lampt.eeecs.qub.ac.uk/API/";
    endpoint += url;

    var sentData = new URLSearchParams();

    for (var key in inputs) {
        sentData.append(key, inputs[key])
    }

    // Fetch json response
    const response = await fetch(endpoint, {
        method: "DELETE",
        body: sentData
    })
    // Get http status num
    const { status } = response;
    // Check if ok (200-299 code)
    if (!response.ok) {
        throw new Error("HTTP error " + status);
    }
    //return the json parsed response
    const data = (await response.json())
    return data;
}
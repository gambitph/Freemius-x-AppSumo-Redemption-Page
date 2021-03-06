document.querySelector( 'form' ).addEventListener("submit", function( e ) {
    // Store reference to form to make later code easier to read
    const form = e.target;
    const button = e.target.querySelector( 'button[type="submit"]' )
    button.setAttribute( 'disabled', 'disabled' )

    // Prevent the default form submit
    e.preventDefault();
  
    // Post data using the Fetch API
    fetch( form.action, {
        method: form.method,
        body: new FormData( form ),
    } ).then( function( response ) {
        if ( response.status === 200 ) {
            window.location.href = './thank-you.html'
        }
        return response.text()
    } ).then( function( text ) {
        if ( text ) {
            alert( text )
        }
    } ).catch( function( error ) {
        alert( 'There was an error redeeming your code: ' + error)
    } ).finally( function() {
        button.removeAttribute( 'disabled' )
    } )
} )

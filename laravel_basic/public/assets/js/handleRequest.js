function validateError(obj) {
    const fields = Object.keys(obj.errors);
    fields.forEach((key, index) => {
        $('#span-'+key+' strong').remove();
        $('#input-'+key).addClass( "is-invalid" );
        $('#span-'+key).append( "<strong>"+ obj.errors[key].join(" ") +"</strong>")
    });
}
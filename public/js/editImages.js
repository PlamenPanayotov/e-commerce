$(function () {
    let attachments = $('#admin_product_images').data('attachments');
    console.log(attachments);
    if (attachments) {
        let path = '/uploads/';
        let images = [];
        attachments.forEach(element => {
            let image = `${path}${element}`;
            images.push(image);
        });
        $("#admin_product_images").fileinput({
            initialPreview: images,
            initialPreviewAsData: true,
            initialPreviewConfig: [
                { size: 930321, width: "120px" }
            ],
            deleteUrl: "/site/file-delete",
            overwriteInitial: true,
            maxFileSize: 500,
            multiple: true,
            // uploadUrl: true

        });
    }

});
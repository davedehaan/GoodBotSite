// Prevent all forms from submitting normally
$('form').submit(function(e) {
    e.preventDefault();
    return false;
});

var goodbot = {
    raid: {
        save: function() {
            var form = $('form').serialize();
            $.ajax({
                url: '/raids/save',
                method: 'POST',
                data: form,
                success: function(data) {
                    if (data.error) {
                        alert(data.error); 
                    }
                    window.location = '/raids';
                }
            });
            return false;
        },
        suggestChannel: function() {
            var raidDate = $('[name=date]').val();
            var raidTitle = $('[name=title]').val();
            var channelName = new Date ('2020-09-23T00:00:00').toLocaleString('default', {'month': 'short'}) + '-' + raidDate.split(/-|\//)[2] + '-' + raidTitle.replace(/ /g, '-');
            $('#channel').val(channelName);
        }
    }
};

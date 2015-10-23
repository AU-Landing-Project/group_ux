define(['require', 'jquery'], function(require, $) {
    $('.group-ux-feature').live('click', function(e) {
        e.preventDefault();

        var span = $(this).children('span').eq(0);
        var guid = span.attr('data-guid');
        var group = span.attr('data-group');
        var featured = span.text();

        if (featured == elgg.echo('group_ux:group:feature')) {
            span.text(elgg.echo('group_ux:group:unfeature'));
        }
        else {
            span.text(elgg.echo('group_ux:group:feature'));
        }


        elgg.action('group_ux/feature', {
            timeout: 20000, // 20 sec
            data: {
                guid: guid,
                group: group
            },
            success: function(result, success, xhr) {
                // nothing to do if everything is ok
            },
            error: function(result, response, xhr) {
                if (response == 'timeout') {
                    elgg.register_error(elgg.echo('group_ux:error:timeout'));
                }
                else {
                    elgg.register_error(elgg.echo('group_ux:error:generic'));
                }

                // reset the text
                span.text(featured);
            }
        });

    });
});
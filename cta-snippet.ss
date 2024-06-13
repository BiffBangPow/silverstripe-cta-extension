<!--
This is a sample snippet showing the usage for the call to action in a template
It assumes that it's already in the right scope for the CTA data to be available
-->

<% if $CTAType != 'None' %>
    <div class="cta">
        <p>
            <% if $CTAType == 'Video' %>
                <button class="cta-link video-trigger" aria-controls="video-$ID"
                        data-vid="$ID">$LinkText</button>
                <dialog id="videoholder-$ID" class="cta-videoholder">
                    <button class="modal-closer" aria-controls="videoholder-$ID">&#x2715;</button>
                    <video controls src="$VideoFile.URL" preload="auto" id="video-$ID"
                           class="video-hidden"></video>
                </dialog>
            <% else %>
                <a href="$CTALink" class="cta-link"
                    <% if $CTAType == 'External' %>target="_blank" rel="noopener"
                    <% else_if $CTAType == 'Download' %>download
                    <% end_if %>>
                    $LinkText
                </a>
            <% end_if %>
        </p>
    </div>

    <% if $CTAType == 'Video' %>
        <% require javascript('biffbangpow/silverstripe-cta-extension:client/dist/javascript/cta-video.js') %>
        <% require css('biffbangpow/silverstripe-cta-extension:client/dist/css/cta-video.css') %>
    <% end_if %>
<% end_if %>

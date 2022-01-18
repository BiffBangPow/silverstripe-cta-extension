<!--
This is a sample snippet showing the usage for the call to action in a template
It assumes that it's already in the right scope for the CTA data to be available
-->

<% if $CTAType != 'None' %>
    <div class="cta">
        <p>
            <a href="$CTALink" class="cta-link"
                <% if $CTAType == 'External' %>target="_blank" rel="noopener"
                <% else_if $CTAType == 'Download' %>download
                <% end_if %>>
                $LinkText
            </a>
        </p>
    </div>
<% end_if %>
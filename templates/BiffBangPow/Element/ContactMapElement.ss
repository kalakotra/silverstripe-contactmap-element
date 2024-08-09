<div class="block <% include BlockClasses %> -- <% include ElementalClass %>" id="$Anchor">
    <div class="<% if FullWidth %>container-fluid g-0<% else %>container<% end_if %>">
        <div class="row justify-content-center ">
            <div class="col-12 <% if FullWidth %><% else %>col-lg-8<% end_if %> text">
                <div class="row">
                    <% if $ShowTitle && $Title %>
                        <div class="col-12 text-center pt-3">
                            <h3 class="block-headline">$Title</h3>
                        </div>
                    <% end_if %>
                    <% if $DisplayLocations %>
                        <div class="col-12 py-3">
                            <div id="map-$ID" class="contactelement-map">
                                <% loop $DisplayLocations %>
                                    <% if $Lat!="" && $Lng!="" %>
                                        <marker data-lat="$Lat" data-lng="$Lng" data-popup='<p><b>$Title</b><br/>$Address</p>'></marker>
                                    <% end_if %>
                                <% end_loop %>
                            </div>
                        </div>
                    <% end_if %>
                </div>
            </div>
        </div>
    </div>
</div>
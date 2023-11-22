<div class="container">
    <% if $Title && $ShowTitle %>
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 element-title">$Title</h2>
            </div>
        </div>
    <% end_if %>
    <% if $Content %>
        <div class="row mb-4">
            <div class="col-12">
                $Content
            </div>
        </div>
    <% end_if %>

    <% loop $DisplayLocations %>
    <div class="row $EvenOdd mt-4">
        <div class="col-12 col-lg-6">
            <div id="map-$ID" class="contactelement-map" data-lat="$Lat" data-lng="$Lng"
                 data-mapzoom="$MapZoom" data-pinurl="$resourceURL('biffbangpow/silverstripe-contactmap-element:client/dist/img/location-pin.png')"></div>
        </div>
        <div class="col-12 col-lg-6">
            <h3>$Title</h3>
            <p class="mt-3">$Address</p>
            <% if $Telephone %>
                <p class="mt-3">Tel: $Telephone</p>
            <% end_if %>
            <% if $Email %>
                <p class="mt-3"><a href="mailto:$Email">$Email</a></p>
            <% end_if %>
            <% if $ShowDirections %>
            <p>
                <a href="$DirectionsLink" target="_blank" rel="nofollow">
                    <%t BiffBangPow\Element\Model\ContactLocation.showdirections 'Show Directions' %>
                </a>
            </p>
            <% end_if %>
        </div>
    </div>
    <% end_loop %>
</div>

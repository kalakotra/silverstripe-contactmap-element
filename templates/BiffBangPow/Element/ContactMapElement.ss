<div class="container">
    <% if $Title && $ShowTitle %>
        <div class="row">
            <div class="col-12">
                <h2 class="mb-5">$Title</h2>
            </div>
        </div>
    <% end_if %>
    <% if $Content %>
        <div class="row">
            <div class="col-12">
                $Content
            </div>
        </div>
    <% end_if %>

    <% loop $DisplayLocations %>
    <div class="row $EvenOdd mt-4">
        <div class="col-12 col-lg-6">
            <div id="map-$ID" class="contactelement-map" data-lat="50.891660601706334" data-lng="-2.279743677113875"
                 data-mapzoom="14"></div>
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
        </div>
    </div>
    <% end_loop %>
</div>

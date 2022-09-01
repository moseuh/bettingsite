<div class="col-md-6">
    <ul class="socials">
        <li><a href="http://www.facebook.com/sharer.php?u={{urlencode(url('/'))}}" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
        <li>
            <a href="http://twitter.com/share?url={{urlencode(url('/'))}}&text={{$basic->sitename}}"  target="_blank" class="twitter">
                <i class="fab fa-twitter"></i>
            </a>
        </li>
        <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url('/'))}}" target="_blank" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>
        <li><a href="http://pinterest.com/pin/create/button/?url={{urlencode(url('/'))}}&media={{urlencode(asset('public/images/logo/logo.png'))}}&description={{{urlencode($basic->sitename)}}}" target="_blank" class="pinterest"><i class="fab fa-pinterest"></i></a></li>
        <li><a href="https://web.skype.com/share?url={{urlencode(url('/'))}}&text={{$basic->sitename}}" target="_blank" class="skypee"><i class="fab fa-skype"></i></a></li>
    </ul>
</div>

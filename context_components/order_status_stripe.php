<div class="info">
    <div class="col-xs-12 col-md-9">

        <div class="infographic">
            <!--Status Section-->
            <div class="info-c">
                <div class="circulo Expired">
                </div>
                <div class="title-info">
                    Expired: <span id="red"></span>
                </div>
            </div>
            <!--Status Section-->
            <div class="info-c">
                <div class="circulo Expiring-soon">
                </div>
                <div class="title-info">
                    Expiring soon: <span id="yellow"></span>
                </div>
            </div>
            <!--Status Section-->
            <div class="info-c">
                <div class="circulo on-Time">
                </div>
                <div class="title-info">
                    on Time: <span id="green"></span>
                </div>
            </div>
            <!--Status Section-->
            <div class="info-c">
                <div class="circulo Ordered-Delayed">
                </div>
                <div class="title-info">
                    Ordered Delayed: <span id="RI"></span>
                </div>
            </div>
            <!--Status Section-->
            <div class="info-c">
                <div class="circulo Ordered">
                </div>
                <div class="title-info">
                    Ordered: <span id="orange"></span>
                </div>
            </div>
        </div>

    </div>
    <?php if ($profile != 'TV') : ?>
        <div class="col-md-3">
            <button type="button" class="btn btn-BD linkToMyModalPartsRequesition">New Parts Request</button>
        </div>
    <?php endif; ?>
</div>
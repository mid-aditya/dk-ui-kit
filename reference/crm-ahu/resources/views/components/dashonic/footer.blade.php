
    <div style="margin-bottom: 80px;"></div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! strip_tags(web_config(request()->getHost(), 'footer-left')) !!}.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                {!! strip_tags(web_config(request()->getHost(), 'footer-right')) !!}
                                {{-- by <a href="https://pichforest.com/" target="_blank" class="text-reset">Pichforest</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

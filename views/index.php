<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ByteArk Sample Secure URL Generator</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://qoder.s3.byteark.com/player/v0.3.4/byteark-player.min.css">
        <!-- [if lt IE 9]>
        <script src="//qoder.s3.byteark.com/player/v0.3.4/byteark-player.ie8.min.css"></script>
        <![endif]-->
    </head>
    <body>
        <a href="https://github.com/byteark/byteark-sdk-php-example">
            <img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png">
        </a>
        <div class="container mt-5 mb-5">
            <h4>ByteArk Sample Secure URL Generator</h4>
            <?php if (array_get($response, 'error')) { ?>
            <div class="alert alert-danger mt-5" role="alert">
                <strong>Error</strong> <?php echo array_get($response, 'error'); ?>
            </div>
            <?php } ?>
            <form method="POST" action="index.php#result">
                <h5 class="mt-5">Signer Options</h5>
                <div class="form-group">
                    <label for="access_id">Access ID <span class="text-muted">(Currently optional)</span></label>
                    <input class="form-control" type="text" name="access_id" value="<?php echo array_get($response, 'access_id', ''); ?>">
                </div>
                <div class="form-group">
                    <label for="access_secret">Access Secret</label>
                    <input class="form-control" type="password" name="access_secret" value="<?php echo array_get($response, 'access_secret', ''); ?>">
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="skip_url_encoding" value="1" <?php if (array_get($response, 'skip_url_encoding')) echo 'checked'; ?>>
                        Skip URL Encoding
                    </label>
                </div>
                <h5 class="mt-5">Sign Options</h5>
                <div class="form-group">
                    <label for="method">HTTP Method</label>
                    <select class="form-control" name="method">
                        <option value="GET" <?php if (array_get($response, 'method') == 'GET') echo 'selected'; ?>>GET</option>
                        <option value="HEAD" <?php if (array_get($response, 'method') == 'HEAD') echo 'selected'; ?>>HEAD</option>
                        <option value="POST" <?php if (array_get($response, 'method') == 'POST') echo 'selected'; ?>>POST</option>
                        <option value="PUT" <?php if (array_get($response, 'method') == 'PUT') echo 'selected'; ?>>PUT</option>
                        <option value="DELETE" <?php if (array_get($response, 'method') == 'DELETE') echo 'selected'; ?>>DELETE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input class="form-control" type="text" name="url" value="<?php echo array_get($response, 'url', ''); ?>">
                </div>
                <div class="form-group">
                    <label for="expires">Expires (Timestamp)</label>
                    <input class="form-control" type="text" name="expires" value="<?php echo array_get($response, 'expires', $response['suggested_expires']); ?>">
                    <small id="emailHelp" class="form-text text-muted">
                        Current timestamp is <?php echo array_get($response, 'current_timestamp', ''); ?>
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">Geo Allow Country <span class="text-muted">(Optional)</span></label>
                    <input class="form-control" type="text" name="geo_allow" value="<?php echo array_get($response, 'geo_allow', ''); ?>">
                    <small class="form-text text-muted">
                        Comma separated list of countries allowing to access the specified URL
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">Geo Block Country <span class="text-muted">(Optional)</span></label>
                    <input class="form-control" type="text" name="geo_block" value="<?php echo array_get($response, 'geo_block', ''); ?>">
                    <small class="form-text text-muted">
                        Comma separated list of countries which will denied access to the specified URL (this takes precedence 'over' geo allow country)
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">Max Resolution <span class="text-muted">(Optional)</span></label>
                    <input class="form-control" type="text" name="max_resolution" value="<?php echo array_get($response, 'max_resolution', ''); ?>">
                    <small class="form-text text-muted">
                        Max resolution for the video (available for some services only)
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">Origin<span class="text-muted">(Optional)</span></label>
                    <input class="form-control" type="text" name="referer" value="<?php echo array_get($response, 'origin', ''); ?>">
                    <small class="form-text text-muted">
                      To testing opening withinin this page, please use this value: https://docs.byteark.com
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">Referer<span class="text-muted">(Optional)</span></label>
                    <input class="form-control" type="text" name="referer" value="<?php echo array_get($response, 'referer', ''); ?>">
                    <small class="form-text text-muted">
                      To testing opening withinin this page, please use this value: https://docs.byteark.com/examples/byteark-sdk-php-example/index.php
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">Client IP <span class="text-muted">(Optional, Legacy)</span></label>
                    <input class="form-control" type="text" name="client_ip" value="<?php echo array_get($response, 'client_ip', ''); ?>">
                    <small class="form-text text-muted">
                        Current client IP is <?php echo array_get($response, 'current_client_ip', ''); ?>
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">User Agent <span class="text-muted">(Optional, Legacy)</span></label>
                    <input class="form-control" type="text" name="user_agent" value="<?php echo array_get($response, 'user_agent', ''); ?>">
                    <small class="form-text text-muted">
                        Current user agent is <?php echo array_get($response, 'current_user_agent', ''); ?>
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">Path Prefix <span class="text-muted">(Required if you want to sign a HLS (.m3u8) URL)</span></label>
                    <input class="form-control" type="text" name="path_prefix" value="<?php echo array_get($response, 'path_prefix', ''); ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
                <h5 class="mt-5">Result</h5>
                <div id="result" class="form-group">
                    <label for="secure_url">Generated String to Sign (Last line with secret are excluded for security reason)</label>
                    <textarea class="form-control" name="string_to_sign" rows="8" readonly><?php echo array_get($response, 'string_to_sign', ''); ?></textarea>
                </div>
                <div id="result" class="form-group">
                    <label for="secure_url">Generated Secure URL</label>
                    <input id="secure_url" class="form-control" type="text" name="secure_url" value="<?php echo array_get($response, 'secure_url', ''); ?>" readonly>
                </div>
                <?php if (array_get($response, 'secure_url')) { ?>
                <div id="result" class="form-group">
                    <a id="openLinkButton" class="btn btn-primary" target="_blank" href="<?php echo array_get($response, 'secure_url', ''); ?>">Open</a>
                    <button id="showImageButton" type="button" class="btn btn-primary">Show Image</button>
                    <button id="showVideoButton" type="button" class="btn btn-primary">Show Video</button>
                </div>
                <?php } ?>
                <div id="preview" class="form-group">
                </div>
            </form>
        </div>
    </body>
    <script
        src="https://code.jquery.com/jquery-3.2.1.slim.js"
        integrity="sha256-tA8y0XqiwnpwmOIl3SGAcFl2RvxHjA8qp0+1uCGmRmg="
        crossorigin="anonymous"></script>
    <script src="https://qoder.s3.byteark.com/player/v0.3.4/byteark-player.min.js"></script>
    <script>
        $('#showImageButton').click(function() {
            $('#preview').empty();

            var img = $('<img>');
            img.attr('src', $('#secure_url').val());
            img.appendTo('#preview');
        });
        $('#showVideoButton').click(function() {
            $('#preview').empty();

            var playerElement = $('<video id="player" class="video-js byteark-skin" width="854" height="480" autoplay controls playsinline webkit-playsinline></video>');
            playerElement.appendTo('#preview');

            byteark('player', {
                swf: 'https://qoder.s3.byteark.com/player/v0.3.4/byteark-player.swf',
                media: {
                    sources: [{
                        src: $('#secure_url').val(),
                        type: 'application/x-mpegURL'
                    }],
                },
            });
        });
    </script>
</html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ByteArk Sample Secure URL Generator</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    </head>
    <body>
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
                    <label for="access_id">Access ID (Currently optional)</label>
                    <input class="form-control" type="text" name="access_id" value="<?php echo array_get($response, 'access_id', ''); ?>">
                </div>
                <div class="form-group">
                    <label for="access_secret">Access Secret</label>
                    <input class="form-control" type="text" name="access_secret" value="<?php echo array_get($response, 'access_secret', ''); ?>">
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
                    <input class="form-control" type="text" name="expires" value="<?php echo array_get($response, 'expires', ''); ?>">
                    <small id="emailHelp" class="form-text text-muted">
                        Current timestamp is <?php echo array_get($response, 'current_timestamp', ''); ?>
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">Client IP (Optional)</label>
                    <input class="form-control" type="text" name="client_ip" value="<?php echo array_get($response, 'client_ip', ''); ?>">
                    <small id="emailHelp" class="form-text text-muted">
                        Current client IP is <?php echo array_get($response, 'current_client_ip', ''); ?>
                    </small>
                </div>
                <div class="form-group">
                    <label for="expires">User Agent (Optional)</label>
                    <input class="form-control" type="text" name="usage_agent" value="<?php echo array_get($response, 'user_agent', ''); ?>">
                </div>
                <div class="form-group">
                    <label for="expires">Path Prefix (Optional)</label>
                    <input class="form-control" type="text" name="path_prefix" value="<?php echo array_get($response, 'path_prefix', ''); ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
                <h5 class="mt-5">Result</h5>
                <div id="result" class="form-group">
                    <label for="secure_url">Generated Secure URL</label>
                    <input class="form-control" type="text" name="secure_url" value="<?php echo array_get($response, 'secure_url', ''); ?>" readonly>
                </div>
            </form>
        </div>
    </body>
</html>

    
    </main>
    <?php if($sessionMessages = getMessages("message")): ?>
        <div id="layout-messages" onclick="this.remove();">
            <div id="messages">
            <?php foreach($sessionMessages as $cle => $messages): ?>
                <?php foreach($messages as $message): ?>
                    <div class="alert alert-<?= $cle ?>"><?= $message ?></div>
                <?php endforeach ?>
            <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>
</body>
</html>

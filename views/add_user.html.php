<h2 class="text-center alert alert-info mt-1">Utilisateurs autorisés</h2>
<form action="bin/manage_users.php"  method="post" class="mt-2">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th class=""><i class="bi-people-fill"></i></th>
                <th ><i class="bi-passport"></i> </th>
                <th class="col-1"><i class="bi-gear"></i></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($authorizedUsers as $nickname => $password): ?>
            <tr>
                <td class="td-edit">
                    <input class="edit" value="<?= $nickname ?>" id="input<?= $nickname ?>" disabled>
                </td>
                <td class="td-edit">
                    <input class="edit" value="<?= $password ?>" disabled>
                </td>                
                <td >
                    <label class="custom-checkbox">
                        <input type="checkbox" name="<?= $nickname ?>" value="true" class="crossout">
                        <span class="checkmark"></span>
                    </label>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>

        <tfoot >
            <tr class="table-dark">
                <td colspan="3"></td>
            </tr>
            <tr>
                <td><input type="text" name="nickname" class="form-control" autofocus placeholder="nouvel utilisateur autorisé..."></td>
                <td><input type="text" name="password" class="form-control"  placeholder="mot de passe par défaut..."></td>
                <th>
                    <button type="submit" id="btAdd" class="btn form-control btn-secondary" ><i class="bi-clipboard-plus"></i></button>
                </th>
            </tr>
        </tfoot>
    </table>
</form>

<?php
require_once './config/config.php';
require_once './database/connect.php';
require_once('./views/Layouts/header.php');
$sql = "SELECT * FROM rates ORDER BY amount ASC";
$rates = $conn->query($sql);
?>
<div class="rtl max-w-2xl mx-auto py-20 sm:px-6 lg:px-8 bg-white rounded-lg shadow-sm mt-11">
    <FormRelation @submitted="LoadPrice">
        <template #form>
            <!-- Name -->
            <div class="pb-2">
                <InputLabel for="customer" value="مشتری" />
                <TextInput id="customer" v-model="form.customer" type="number" class="mt-1 block w-full" autocomplete="customer" />
                <InputError :message="form.errors.customer" class="mt-2" />
            </div>
            <div class="pb-2">
                <InputLabel for="code" value="کدهای مدنظر" />
                <textarea rows="7" id="code" v-model="form.code" type="text" class="ltr mt-1 shadow-sm block w-full rounded-md border-gray-300" placeholder="لطفا کد های مود نظر خود را در خط های مجزا قرار دهید">
                                    </textarea>
                <InputError :message="form.errors.code" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                جستجو </PrimaryButton>
        </template>
    </FormRelation>
</div>
<script>
</script>
<?php
require_once('./views/Layouts/footer.php');

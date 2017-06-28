<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('setting');
            });
        },
        data() {
            return {
                form: {},
            };
        },
        methods: {
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
            submitAddGroup() {
                const self = this;
                self.loading = true;
                self.$refs.groupAdd.validate(valid => {
                    if (valid) {
                        window.console.log(valid);
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
        },
    };
</script>
<template>
    <div class="setting-wrap">
        <div class="slide-group-edit">
            <div class="edit-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>轮播图插件-编辑图片内容</span>
            </div>
            <card :bordered="false">
                <div class="prompt-box">
                    <p>关于</p>
                    <p>每编辑一张图片需要点击保存，所有相关设置完成，使用底部的"更新板块内容"前台展示页面才会变化</p>
                </div>
                <i-form ref="form" :model="form" :rules="ruleValidate" :label-width="100">

                    <!--<row>
                        <i-col span="14">
                            <form-item>
                                <i-button :loading="loading" type="primary"
                                          @click.native="submitSetGroup">
                                    <span v-if="!loading">确认提交</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                            </form-item>
                        </i-col>
                    </row>-->
                </i-form>
            </card>
        </div>
    </div>
</template>
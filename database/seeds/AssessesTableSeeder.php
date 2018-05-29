<?php

use Illuminate\Database\Seeder;

class AssessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Assess::saveAll([
            ['name' => '冠心病', 'score' => 3, 'type' => 1],
            ['name' => '脑卒中', 'score' => 3, 'type' => 1],
            ['name' => '静脉血栓', 'score' => 3, 'type' => 1],
            ['name' => '痛风', 'score' => 3, 'type' => 1],
            ['name' => '抑郁症', 'score' => 3, 'type' => 1],
            ['name' => '哮喘', 'score' => 3, 'type' => 1],
            ['name' => '高血压', 'score' => 3, 'type' => 1],
            ['name' => '糖尿病', 'score' => 3, 'type' => 1],
            ['name' => '肝炎', 'score' => 2, 'type' => 1],
            ['name' => '胃溃疡', 'score' => 2, 'type' => 1],
            ['name' => '肥胖超重', 'score' => 2, 'type' => 1],
            ['name' => '结核病', 'score' => 2, 'type' => 1],
            ['name' => '慢性气管炎', 'score' => 2, 'type' => 1],
            ['name' => '血脂异常', 'score' => 2, 'type' => 1],
            ['name' => '骨质疏松贫血', 'score' => 2, 'type' => 1],
            ['name' => '肾炎', 'score' => 1, 'type' => 1],
            ['name' => '甲亢', 'score' => 1, 'type' => 1],
            ['name' => '骨刺', 'score' => 1, 'type' => 1],
            ['name' => '关节炎', 'score' => 1, 'type' => 1],
            ['name' => '颈椎病', 'score' => 1, 'type' => 1],
            ['name' => '腰间盘突出', 'score' => 1, 'type' => 1],
            ['name' => '前列腺炎', 'score' => 1, 'type' => 1],
            ['name' => '痔疮', 'score' => 1, 'type' => 1],
            ['name' => '湿疹', 'score' => 1, 'type' => 1],
            ['name' => '都没有', 'score' => 0, 'type' => 1],
            ['name' => '企业家', 'score' => 3, 'type' => 2],
            ['name' => '管理人员', 'score' => 3, 'type' => 2],
            ['name' => '矿业及化工工人', 'score' => 3, 'type' => 2],
            ['name' => '军人', 'score' => 2, 'type' => 2],
            ['name' => '其他工人', 'score' => 2, 'type' => 2],
            ['name' => '自由职业', 'score' => 2, 'type' => 2],
            ['name' => '企业职员', 'score' => 1, 'type' => 2],
            ['name' => '政府公务员', 'score' => 1, 'type' => 2],
            ['name' => '务农', 'score' => 1, 'type' => 2],
            ['name' => '高血压', 'score' => 3, 'type' => 3],
            ['name' => '糖尿病', 'score' => 3, 'type' => 3],
            ['name' => '肿瘤', 'score' => 3, 'type' => 3],
            ['name' => '哮喘', 'score' => 3, 'type' => 3],
            ['name' => '血脂异常', 'score' => 2, 'type' => 3],
            ['name' => '肥胖超重', 'score' => 2, 'type' => 3],
            ['name' => '冠心病', 'score' => 2, 'type' => 3],
            ['name' => '抑郁症', 'score' => 1, 'type' => 3],
            ['name' => '骨质疏松', 'score' => 1, 'type' => 3],
            ['name' => '都没有', 'score' => 0, 'type' => 3],
            ['name' => '吸烟', 'score' => 3, 'type' => 4],
            ['name' => '经常饮酒', 'score' => 3, 'type' => 4],
            ['name' => '高盐口重', 'score' => 3, 'type' => 4],
            ['name' => '经常熬夜', 'score' => 2, 'type' => 4],
            ['name' => '久坐', 'score' => 2, 'type' => 4],
            ['name' => '减肥', 'score' => 2, 'type' => 4],
            ['name' => '缺乏锻炼', 'score' => 1, 'type' => 4],
            ['name' => '饮食过量', 'score' => 1, 'type' => 4],
            ['name' => '都没有', 'score' => 0, 'type' => 4],
            ['name' => '血压高', 'score' => 3, 'type' => 5],
            ['name' => '血糖高', 'score' => 3, 'type' => 5],
            ['name' => '血脂高', 'score' => 3, 'type' => 5],
            ['name' => '神经衰弱失眠', 'score' => 3, 'type' => 5],
            ['name' => '话语不清', 'score' => 3, 'type' => 5],
            ['name' => '手抖', 'score' => 3, 'type' => 5],
            ['name' => '心悸', 'score' => 2, 'type' => 5],
            ['name' => '焦躁易怒', 'score' => 2, 'type' => 5],
            ['name' => '容易疲劳', 'score' => 2, 'type' => 5],
            ['name' => '头晕头痛', 'score' => 2, 'type' => 5],
            ['name' => '嗜睡', 'score' => 2, 'type' => 5],
            ['name' => '易过敏', 'score' => 2, 'type' => 5],
            ['name' => '肥胖', 'score' => 1, 'type' => 5],
            ['name' => '关节僵痛', 'score' => 1, 'type' => 5],
            ['name' => '抑郁', 'score' => 1, 'type' => 5],
            ['name' => '孕期', 'score' => 1, 'type' => 5],
            ['name' => '术后恢复', 'score' => 1, 'type' => 5],
            ['name' => '更年期', 'score' => 1, 'type' => 5],
            ['name' => '口苦', 'score' => 1, 'type' => 5],
            ['name' => '都没有', 'score' => 0, 'type' => 5]
        ]);
    }
}

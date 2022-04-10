<?php

namespace Database\Seeders;

use App\Models\Parameter\SoftSkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoftSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SoftSkill::create(['name' => 'Negotiation', 'category' => 'Communication', 'description' => 'deal with complaints, settle disputes, resolve grievances, resolve conflicts, reach compromise']);
        SoftSkill::create(['name' => 'Persuasion', 'category' => 'Communication', 'description' => 'convince others, building rapport, focusing on the benefits, countering objections, finding common ground']);
        SoftSkill::create(['name' => 'Written Communication', 'category' => 'Communication', 'description' => 'develop coherent content, apply structure, use appropriate vocabulary, establish tone, build outlines']);
        SoftSkill::create(['name' => 'Verbal Communication', 'category' => 'Communication', 'description' => 'speak articulately, convey message, provide constructive feedback, state clear explanations, ask effective questions']);
        SoftSkill::create(['name' => 'Presentation', 'category' => 'Communication', 'description' => 'connect with an audience, use storytelling techniques, convey impactful information, provide simple explanations, use engaging visual materials']);
        SoftSkill::create(['name' => 'Active Listening', 'category' => 'Communication', 'description' => 'ask effective questions, retain important information, withhold judgment and bias, clarify details, paraphrase ideas and concerns']);
        SoftSkill::create(['name' => 'Adaptability', 'category' => 'Critical Thinking', 'description' => 'deal with ambiguity, show continuous improvement, demonstrate resourcefulness, manage diverse stakeholders, source new methods and techniques']);
        SoftSkill::create(['name' => 'Logical Thinking', 'category' => 'Critical Thinking', 'description' => 'observe and analyze phenomena, identify trends and patterns, decide based on facts, outline structured process/steps, make rational conclusions']);
        SoftSkill::create(['name' => 'Problem Solving', 'category' => 'Critical Thinking', 'description' => 'identify underlying issue/s, analyze contributing factors, identify feasible options, evaluate possible solutions, implement rational solutions']);
        SoftSkill::create(['name' => 'Design Thinking', 'category' => 'Critical Thinking', 'description' => 'research users\' needs, state users\' needs and problems, challenge assumptions, identify innovative solutions, test solution/s']);
        SoftSkill::create(['name' => 'Research', 'category' => 'Critical Thinking', 'description' => 'find, organise, analyse and present relevant information about a specific subject']);
        SoftSkill::create(['name' => 'Creativity', 'category' => 'Critical Thinking', 'description' => 'develop new ideas, enhance efficiency and discover solutions to complex problems']);
        SoftSkill::create(['name' => 'Decision Making', 'category' => 'Leadership and Management', 'description' => 'use facts from a variety of sources to arrive at decitions']);
        SoftSkill::create(['name' => 'Delegation', 'category' => 'Leadership and Management', 'description' => 'identify when and which task/s to delegate, explain task/s and expectations clearly, provide contructive feedback']);
        SoftSkill::create(['name' => 'Time Management', 'category' => 'Leadership and Management', 'description' => 'manage your own time and the time of others, work efficiently, analyze workload, assign priorities, maintain focus on productive endeavors ']);
        SoftSkill::create(['name' => 'Motivation', 'category' => 'Leadership and Management', 'description' => 'focus on the good in a situation, see  challenges as a learning opportunity, use optimistic words when speaking about conflicts or challenges, encourage with positive praise and celebrations']);
        SoftSkill::create(['name' => 'Mentoring', 'category' => 'Leadership and Management', 'description' => 'support the learning, development and progress of another person; provide information, advice and assistance in a way that empowers the mentee']);
        SoftSkill::create(['name' => 'Project Management', 'category' => 'Leadership and Management', 'description' => 'plan and organize resources to move a specific task, event, or duty towards completion']);
        SoftSkill::create(['name' => 'Change Management', 'category' => 'Leadership and Management', 'description' => 'develop change management plan, set goals for organizational changes, communicate change management plans to stakeholders']);
        SoftSkill::create(['name' => 'Stress Management', 'category' => 'Personal Effectiveness', 'description' => 'apply tools, strategies, or techniques that reduce stress and reduce the negative impacts stress has on your mental or physical well-being']);
        SoftSkill::create(['name' => 'Multitasking', 'category' => 'Personal Effectiveness', 'description' => 'juggle different work activities and shifting attention from one task to another, meet the demands of several different stakeholders without dropping the ball']);
        SoftSkill::create(['name' => 'Organization', 'category' => 'Personal Effectiveness', 'description' => 'keep calm and prepared with systematic planning and scheduling, break a job down into smaller projects and goals']);
        SoftSkill::create(['name' => 'Teamwork', 'category' => 'Personal Effectiveness', 'description' => 'effectively perform within team environments, including the ability to recognise and capitalise on individuals\' different thinking, experience and skills']);
        SoftSkill::create(['name' => 'Assertiveness', 'category' => 'Personal Effectiveness', 'description' => 'convey information and ideas in an open and direct way while maintaining respect for those you’re speaking with']);
        SoftSkill::create(['name' => 'Confidence', 'category' => 'Personal Effectiveness', 'description' => 'face fears and pursue new challenges and goals, no matter how difficult they seem']);
        SoftSkill::create(['name' => 'Self-Motivation', 'category' => 'Personal Effectiveness', 'description' => 'drive yourself to complete various tasks and duties efficiently']);
    }
}

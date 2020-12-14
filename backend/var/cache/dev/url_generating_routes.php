<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    'get_category_list' => [[], ['_controller' => 'App\\Controller\\CategoryController::readCategoryList'], [], [['text', '/api/categories']], [], []],
    'get_category' => [['id'], ['_controller' => 'App\\Controller\\CategoryController::readCategory'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/categories']], [], []],
    'create_category' => [[], ['_controller' => 'App\\Controller\\CategoryController::createCategory'], [], [['text', '/api/categories']], [], []],
    'update_category' => [['id'], ['_controller' => 'App\\Controller\\CategoryController::updateCategory'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/categories']], [], []],
    'delete_category' => [['id'], ['_controller' => 'App\\Controller\\CategoryController::deleteCategory'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/categories']], [], []],
    'get_education_list' => [[], ['_controller' => 'App\\Controller\\EducationController::readEducationList'], [], [['text', '/api/educations']], [], []],
    'get_education' => [['id'], ['_controller' => 'App\\Controller\\EducationController::readEducation'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/educations']], [], []],
    'create_education' => [[], ['_controller' => 'App\\Controller\\EducationController::createEducation'], [], [['text', '/api/educations']], [], []],
    'update_education' => [['id'], ['_controller' => 'App\\Controller\\EducationController::updateEducation'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/educations']], [], []],
    'delete_education' => [['id'], ['_controller' => 'App\\Controller\\EducationController::deleteEducation'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/educations']], [], []],
    'get_experience_list' => [[], ['_controller' => 'App\\Controller\\ExperienceController::readExperienceList'], [], [['text', '/api/experiences']], [], []],
    'get_experience' => [['id'], ['_controller' => 'App\\Controller\\ExperienceController::readExperience'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/experiences']], [], []],
    'create_experiences' => [[], ['_controller' => 'App\\Controller\\ExperienceController::createExperience'], [], [['text', '/api/experiences']], [], []],
    'update_experience' => [['id'], ['_controller' => 'App\\Controller\\ExperienceController::updateExperience'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/experiences']], [], []],
    'delete_experience' => [['id'], ['_controller' => 'App\\Controller\\ExperienceController::deleteExperience'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/experiences']], [], []],
    'get_project_list' => [[], ['_controller' => 'App\\Controller\\ProjectController::readProjectList'], [], [['text', '/api/projects']], [], []],
    'get_project' => [['id'], ['_controller' => 'App\\Controller\\ProjectController::readProject'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/projects']], [], []],
    'create_project' => [[], ['_controller' => 'App\\Controller\\ProjectController::createProject'], [], [['text', '/api/projects']], [], []],
    'update_project' => [['id'], ['_controller' => 'App\\Controller\\ProjectController::updateProject'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/projects']], [], []],
    'delete_project' => [['id'], ['_controller' => 'App\\Controller\\ProjectController::deleteProject'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/projects']], [], []],
    'register' => [[], ['_controller' => 'App\\Controller\\SecurityController::register'], [], [['text', '/api/register']], [], []],
    'login' => [[], ['_controller' => 'App\\Controller\\SecurityController::login'], [], [['text', '/api/login']], [], []],
    'get_skill_list' => [[], ['_controller' => 'App\\Controller\\SkillController::readSkillList'], [], [['text', '/api/skills']], [], []],
    'get_skill' => [['id'], ['_controller' => 'App\\Controller\\SkillController::readSkill'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/skills']], [], []],
    'create_skill' => [[], ['_controller' => 'App\\Controller\\SkillController::createSkill'], [], [['text', '/api/skills']], [], []],
    'update_skill' => [['id'], ['_controller' => 'App\\Controller\\SkillController::updateSkill'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/skills']], [], []],
    'delete_skills' => [['id'], ['_controller' => 'App\\Controller\\SkillController::deleteSkill'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/skills']], [], []],
    'get_software_list' => [[], ['_controller' => 'App\\Controller\\SoftwareController::readSoftwareList'], [], [['text', '/api/softwares']], [], []],
    'get_software' => [['id'], ['_controller' => 'App\\Controller\\SoftwareController::readSoftware'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/softwares']], [], []],
    'create_software' => [[], ['_controller' => 'App\\Controller\\SoftwareController::createSoftware'], [], [['text', '/api/softwares']], [], []],
    'update_software' => [['id'], ['_controller' => 'App\\Controller\\SoftwareController::updateSoftware'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/softwares']], [], []],
    'delete_software' => [['id'], ['_controller' => 'App\\Controller\\SoftwareController::deleteSoftware'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/softwares']], [], []],
    'api_login_check' => [[], [], [], [['text', '/api/login_check']], [], []],
];

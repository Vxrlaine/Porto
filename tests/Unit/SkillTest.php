<?php

namespace Tests\Unit;

use App\Models\Skill;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SkillTest extends TestCase
{
    #[Test]
    public function it_can_create_a_skill()
    {
        $skill = Skill::create([
            'name' => 'Laravel',
            'category' => 'Framework',
            'proficiency' => 85,
            'is_active' => true,
            'order' => 1,
        ]);

        $this->assertInstanceOf(Skill::class, $skill);
        $this->assertEquals('Laravel', $skill->name);
        $this->assertEquals(85, $skill->proficiency);
    }

    #[Test]
    public function it_validates_proficiency_range()
    {
        $skill = Skill::create([
            'name' => 'PHP',
            'proficiency' => 50,
        ]);

        $this->assertGreaterThanOrEqual(0, $skill->proficiency);
        $this->assertLessThanOrEqual(100, $skill->proficiency);
    }

    #[Test]
    public function it_can_get_skills_by_category()
    {
        Skill::create(['name' => 'Laravel', 'category' => 'Framework', 'proficiency' => 80, 'is_active' => true]);
        Skill::create(['name' => 'React', 'category' => 'Framework', 'proficiency' => 75, 'is_active' => true]);
        Skill::create(['name' => 'Git', 'category' => 'Tool', 'proficiency' => 90, 'is_active' => true]);

        $frameworkSkills = Skill::where('category', 'Framework')->get();

        $this->assertCount(2, $frameworkSkills);
    }

    #[Test]
    public function it_casts_proficiency_to_integer()
    {
        $skill = Skill::create([
            'name' => 'JavaScript',
            'proficiency' => '75',
        ]);

        $this->assertIsInt($skill->proficiency);
        $this->assertEquals(75, $skill->proficiency);
    }
}

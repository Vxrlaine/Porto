<?php

namespace Tests\Unit;

use App\Models\Project;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    #[Test]
    public function it_can_create_a_project()
    {
        $project = Project::create([
            'title' => 'Test Project',
            'description' => 'A test project description',
            'is_active' => true,
            'order' => 1,
        ]);

        $this->assertInstanceOf(Project::class, $project);
        $this->assertEquals('Test Project', $project->title);
        $this->assertTrue($project->is_active);
    }

    #[Test]
    public function it_can_update_a_project()
    {
        $project = Project::create([
            'title' => 'Original Title',
            'is_active' => true,
        ]);

        $project->update([
            'title' => 'Updated Title',
        ]);

        $this->assertEquals('Updated Title', $project->fresh()->title);
    }

    #[Test]
    public function it_can_delete_a_project()
    {
        $project = Project::create([
            'title' => 'To Be Deleted',
            'is_active' => true,
        ]);

        $project->delete();

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    #[Test]
    public function it_can_get_active_projects()
    {
        Project::create(['title' => 'Active Project 1', 'is_active' => true, 'order' => 1]);
        Project::create(['title' => 'Active Project 2', 'is_active' => true, 'order' => 2]);
        Project::create(['title' => 'Inactive Project', 'is_active' => false, 'order' => 3]);

        $activeProjects = Project::where('is_active', true)->get();

        $this->assertCount(2, $activeProjects);
    }

    #[Test]
    public function it_casts_boolean_correctly()
    {
        $project = Project::create([
            'title' => 'Test',
            'is_active' => '1',
        ]);

        $this->assertTrue($project->is_active);
        $this->assertIsBool($project->is_active);
    }

    #[Test]
    public function it_can_fill_title()
    {
        $project = new Project();
        $project->fill(['title' => 'Fillable Test']);
        
        $this->assertEquals('Fillable Test', $project->title);
    }
}

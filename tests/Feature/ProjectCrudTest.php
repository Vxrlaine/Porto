<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }

    #[Test]
    public function admin_can_view_projects_list()
    {
        Project::create([
            'title' => 'Project 1',
            'description' => 'Description 1',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/projects');

        $response->assertStatus(200);
        $response->assertViewHas('projects');
    }

    #[Test]
    public function admin_can_create_project()
    {
        $projectData = [
            'title' => 'New Project',
            'description' => 'Project description',
            'client_name' => 'Client Name',
            'project_url' => 'https://example.com',
            'is_active' => true,
            'order' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/projects', $projectData);

        $response->assertRedirect();
        $this->assertDatabaseHas('projects', [
            'title' => 'New Project',
            'client_name' => 'Client Name',
        ]);
    }

    #[Test]
    public function admin_can_update_project()
    {
        $project = Project::create([
            'title' => 'Original Title',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)
            ->put("/admin/projects/{$project->id}", [
                'title' => 'Updated Title',
                'description' => 'Updated description',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Updated Title',
        ]);
    }

    #[Test]
    public function admin_can_delete_project()
    {
        $project = Project::create([
            'title' => 'To Delete',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete("/admin/projects/{$project->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    #[Test]
    public function non_admin_cannot_create_project()
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)
            ->post('/admin/projects', [
                'title' => 'Unauthorized Project',
            ]);

        $response->assertForbidden();
    }

    #[Test]
    public function guest_cannot_access_projects()
    {
        $response = $this->get('/admin/projects');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function admin_can_upload_project_image()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('project.jpg');

        $response = $this->actingAs($this->admin)
            ->post('/admin/projects', [
                'title' => 'Project with Image',
                'image_path' => $image,
                'is_active' => true,
            ]);

        $response->assertRedirect();
        
        Storage::disk('public')->assertExists('projects/' . $image->hashName());
    }

    #[Test]
    public function project_validation_fails_with_invalid_data()
    {
        $response = $this->actingAs($this->admin)
            ->post('/admin/projects', [
                'title' => '',
                'project_url' => 'not-a-url',
            ]);

        $response->assertSessionHasErrors(['title', 'project_url']);
    }
}

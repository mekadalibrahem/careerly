<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional CV</title>
    <style>
        /* Core Styling and Fonts */
        body {
            font-family: 'Roboto', sans-serif; /* General text font */
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5; /* Light background for the page */
        }

        /* CV Container: Mimics A4 page size and centers the content */
        .cv-container {
            /*max-width: 900px; !* Width similar to a standard resume *!*/
            /*margin: 0 auto;*/
            /*background-color: #fff;*/
            /*padding: 40px 50px;*/
            /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); !* Subtle shadow for a lift effect *!*/
        }

        /* Typography and Headings */
        h1 {
            font-family: 'Playfair Display', serif; /* Distinctive, professional font for the name */
            font-size: 2.5em;
            color: #000;
            margin-bottom: 5px;
        }

        h2 {
            font-family: 'Roboto', sans-serif;
            font-size: 1.2em;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            border-bottom: 2px solid #000; /* Separator line like in the original CV */
            padding-bottom: 5px;
            margin-top: 25px;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        h3 {
            font-size: 1em;
            font-weight: 700;
            margin: 0;
        }

        p {
            margin: 0 0 5px 0;
        }

        a {
            color: #000;
            text-decoration: none;
            border-bottom: 1px dashed #333; /* Underline links subtly */
        }
        a:hover {
            color: #555;
            border-bottom: 1px solid #555;
        }


        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .bio-title {
            font-size: 1.1em;
            font-weight: 400;
            margin-bottom: 10px;
        }
        .contact-info {
            font-size: 0.9em;
            color: #666;
        }
        .contact-info span {
            margin: 0 5px;
        }

        /* Main Content Wrapper (Two Columns) */
        .content-wrapper {
            display: flex;
            gap: 30px; /* Space between the two columns */
        }

        .main-content {
            flex: 3; /* Takes up more space for education, experience, projects */
        }

        .sidebar {
            flex: 1; /* Takes up less space for skills, courses, honors */
        }

        /* Section Styling */
        .section {
            margin-bottom: 20px;
        }

        /* Entry Styling (Education, Experience, Project) */
        .entry-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 5px;
        }

        .dates {
            font-size: 0.9em;
            font-style: italic;
            white-space: nowrap; /* Prevents date from wrapping */
        }

        /* Specific Entry Types */
        .education-entry, .experience-entry, .project-entry, .course-entry {
            margin-bottom: 15px;
        }
        .company-location, .degree-info, .grade-info, .course-details {
            font-size: 0.95em;
            margin-bottom: 5px;
        }
        .project-tools {
            font-size: 0.95em;
            margin-top: 5px;
            font-weight: 700;
        }

        /* Lists and Bullet Points */
        .description-list, .bullet-list {
            padding-left: 20px;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .description-list li, .bullet-list li {
            font-size: 0.95em;
            margin-bottom: 3px;
            /* Custom bullet style for professional look */
            list-style-type: disc;
        }
        .skill-list p {
            font-size: 0.95em;
            margin-bottom: 3px;
        }
    </style>

</head>
<body>
<div class="cv-container">
    <header class="header">
        <h1>{{$data['name'] ?? ''}}</h1>

        <div class="contact-info">
            <span>{{$data['email'] ?? ''}}</span> |
            <span>{{$data['phone'] ?? ''}}</span> |
        </div>
    </header>

    <div class="content-wrapper">
        <main class="main-content">
            <section class="section">
                <h2>{{$data['title'] ?? ''}}</h2>
                <div>
                    {{$data['bio'] ?? ''}}
                </div>
            </section>
            @if($data['educations'])
                <section class="section">
                    <h2>Education</h2>
                    @foreach($data['educations'] as $education)
                        <div class="education-entry">
                            <div class="entry-header">
                                <h3 class="institution-name">{{$education->institution ?? ''}}</h3>
                                <span class="dates">{{$education->start_at ?? ''}} – {{$education->end_at ?? ''}}</span>
                            </div>
                            <p class="degree-info">{{$education->degree ?? ''}} in {{$education->name ?? ''}}</p>
                            <p class="grade-info">Grade: {{$education->grade ?? ''}}</p>
                        </div>
                    @endforeach
                </section>
            @endif
            @if($data['projects'])
                <section class="section">
                    <h2>Projects</h2>
                   @foreach($data['projects'] as $project)

                            <div class="project-entry">
                                <div class="entry-header">
                                    <h3 class="project-name"><a href="{{$project->url ?? ''}}" target="_blank">{{$project->name ?? ''}}</a></h3>
{{--                                    <span class="dates">Dates/Timeline (if applicable)</span>--}}
                                </div>
                                <p class="project-tools"><i><b>Tools Used </b></i> {{$project->tools ?? ''}}</p>
                                <ul class="description-list">
                                    <li>{{$project->description ?? ''}}</li>

                                </ul>
                            </div>

                   @endforeach
                </section>
            @endif

            @if($data['courses'])
                <section class="section">
                    <h2>Courses</h2>
                    @foreach($data['courses'] as $course)
                        <div class="experience-entry">
                            <div class="entry-header">
                                <a href="{{$course->url ?? ''}}"  target="_blank">
                                    <h3 class="role">{{$course->name ?? ''}}</h3>
                                </a>
                                <span class="dates">{{$course->duration ?? ''}}</span>
                            </div>
                            <p class="company-location">{{$course->provider ?? ''}}</p>

                        </div>
                    @endforeach
                </section>
            @endif
        </main>

        <aside class="sidebar">

            @if($data['skills'])
                <section class="section">
                    <h2>Skills</h2>
                    <div class="skill-list">
                    @foreach($data['skills'] as $skill)
                            <p> {{$skill->name ?? ''}}</p>
                    @endforeach
                    </div>
                </section>
            @endif




        </aside>
    </div>
</div>
</body>
</html>

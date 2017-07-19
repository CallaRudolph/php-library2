book.html.twig

    {% if books is not empty %}
        <p>Here are the books:</p>
        <ul>
            {% for book in books %}
                <li>{{ book.getTitle }}</li>
            {% endfor %}
        </ul>
    {% endif %} -->

    <h4>Add a task to this category:</h4>

    <form action='/add_tasks' method='post'>
        <input id="category_id" name="category_id" type="hidden" value="{{ category.getId }}">
        <label for='task_id'>Select a Task</label>
        <select id='task_id' name='task_id' type='text'><br>
          {% for task in all_tasks %}
            <option value="{{ task.getId }}"> {{ task.getDescription }} </option>
          {% endfor %}
      </select>

        <button type='submit'>Add task</button>
    </form>
